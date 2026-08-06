<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Menu;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminMenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::with('category');

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $menus = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $categories = MenuCategory::orderBy('position', 'asc')->get();

        return view('admin.menus.index', compact('menus', 'categories'));
    }

    public function create()
    {
        $categories = MenuCategory::orderBy('position', 'asc')->get();
        return view('admin.menus.create', compact('categories'));
    }

    public function store(StoreMenuRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']) . '-' . rand(100, 999);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menus', 'public');
            $validated['image'] = '/storage/' . $path;
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->image_url;
        } else {
            $validated['image'] = 'https://images.unsplash.com/photo-1541167760496-1628856ab772?auto=format&fit=crop&w=600&q=80';
        }

        Menu::create($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully!');
    }

    public function edit(Menu $menu)
    {
        $categories = MenuCategory::orderBy('position', 'asc')->get();
        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $validated = $request->validated();

        if ($validated['name'] !== $menu->name) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . rand(100, 999);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menus', 'public');
            $validated['image'] = '/storage/' . $path;
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->image_url;
        }

        $menu->update($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu updated successfully!');
    }

    public function toggleAvailability(Menu $menu)
    {
        $menu->update(['is_available' => ! $menu->is_available]);
        return back()->with('success', "Availability for '{$menu->name}' updated!");
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu item deleted successfully!');
    }
}
