<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Models\MenuCategory;
use Illuminate\Pagination\LengthAwarePaginator;

class MenuRepository
{
    public function getFilteredMenus(?string $categorySlug = null, ?string $search = null, ?string $sort = null, int $perPage = 12)
    {
        $query = Menu::with('category')->where('is_available', true);

        if ($categorySlug && $categorySlug !== 'all') {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('ingredients', 'like', "%{$search}%");
            });
        }

        if ($sort === 'price_low') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_high') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'rating') {
            $query->orderBy('rating', 'desc');
        } else {
            $query->orderBy('is_bestseller', 'desc')->orderBy('name', 'asc');
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function getBestsellers(int $limit = 4)
    {
        return Menu::with('category')
            ->where('is_available', true)
            ->where('is_bestseller', true)
            ->limit($limit)
            ->get();
    }

    public function getAllCategories()
    {
        return MenuCategory::orderBy('position', 'asc')->get();
    }
}
