<?php

namespace Database\Seeders;

use App\Models\MenuCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Coffee',
                'slug' => 'coffee',
                'icon' => 'coffee',
                'description' => 'Espresso-based creations, pour-overs, and signature house brews.',
                'position' => 1,
            ],
            [
                'name' => 'Non Coffee',
                'slug' => 'non-coffee',
                'icon' => 'milk',
                'description' => 'Creamy matchas, artisan chocolates, and refreshing mocktails.',
                'position' => 2,
            ],
            [
                'name' => 'Tea',
                'slug' => 'tea',
                'icon' => 'cup-soda',
                'description' => 'Single-origin leaf teas, botanical infusions, and iced elixirs.',
                'position' => 3,
            ],
            [
                'name' => 'Meals',
                'slug' => 'meals',
                'icon' => 'utensils-crossed',
                'description' => 'Hearty rice bowls, artisan sandwiches, and comfort dinners.',
                'position' => 4,
            ],
            [
                'name' => 'Pastry',
                'slug' => 'pastry',
                'icon' => 'croissant',
                'description' => 'Freshly baked buttery croissants, Danish pastries, and bagels.',
                'position' => 5,
            ],
            [
                'name' => 'Dessert',
                'slug' => 'dessert',
                'icon' => 'cake',
                'description' => 'Handcrafted cakes, artisan cheesecakes, and sweet bites.',
                'position' => 6,
            ],
        ];

        foreach ($categories as $cat) {
            MenuCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
