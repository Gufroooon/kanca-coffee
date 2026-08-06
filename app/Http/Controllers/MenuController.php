<?php

namespace App\Http\Controllers;

use App\Repositories\MenuRepository;
use App\Models\Menu;
use App\Models\MenuCategory;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function index(Request $request)
    {
        $categorySlug = $request->get('category', 'all');
        $search = $request->get('search');
        $sort = $request->get('sort');

        $categories = $this->menuRepository->getAllCategories();
        $menus = $this->menuRepository->getFilteredMenus($categorySlug, $search, $sort, 12);
        $bestsellers = $this->menuRepository->getBestsellers(4);

        return view('menu.index', compact('menus', 'categories', 'categorySlug', 'search', 'sort', 'bestsellers'));
    }

    public function qr()
    {
        $categories = MenuCategory::with(['menus' => function ($q) {
            $q->where('is_available', true);
        }])->orderBy('position', 'asc')->get();

        return view('menu.qr', compact('categories'));
    }
}
