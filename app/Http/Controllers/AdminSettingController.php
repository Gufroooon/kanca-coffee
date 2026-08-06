<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $galleries = Gallery::orderBy('id', 'desc')->get();

        return view('admin.settings.index', compact('settings', 'galleries'));
    }

    public function updateSettings(Request $request)
    {
        $inputs = $request->except(['_token', '_method']);

        foreach ($inputs as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Website settings saved successfully!');
    }

    public function storeGallery(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
            'caption' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('galleries', 'public');
            $validated['image'] = '/storage/' . $path;
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->image_url;
        } else {
            $validated['image'] = 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=800&q=80';
        }

        Gallery::create($validated);

        return back()->with('success', 'Gallery item added successfully!');
    }

    public function destroyGallery(Gallery $gallery)
    {
        $gallery->delete();
        return back()->with('success', 'Gallery item removed.');
    }
}
