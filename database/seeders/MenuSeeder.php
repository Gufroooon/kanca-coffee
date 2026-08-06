<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $coffeeCat = MenuCategory::where('slug', 'coffee')->first();
        $nonCoffeeCat = MenuCategory::where('slug', 'non-coffee')->first();
        $teaCat = MenuCategory::where('slug', 'tea')->first();
        $mealsCat = MenuCategory::where('slug', 'meals')->first();
        $pastryCat = MenuCategory::where('slug', 'pastry')->first();
        $dessertCat = MenuCategory::where('slug', 'dessert')->first();

        $menus = [
            // Coffee
            [
                'category_id' => $coffeeCat->id,
                'name' => 'Kanca Signature Aren Lattee',
                'slug' => 'kanca-signature-aren-lattee',
                'description' => 'Our legendary espresso blended with organic Gula Aren Java and farm-fresh steamed milk.',
                'price' => 28000,
                'image' => 'https://images.unsplash.com/photo-1541167760496-1628856ab772?auto=format&fit=crop&w=600&q=80',
                'ingredients' => 'Double Espresso, Premium Gula Aren, Fresh Milk, Ice',
                'calories' => 180,
                'is_available' => true,
                'is_bestseller' => true,
                'is_new' => false,
                'rating' => 4.95,
            ],
            [
                'category_id' => $coffeeCat->id,
                'name' => 'Spanish Cortado Velvet',
                'slug' => 'spanish-cortado-velvet',
                'description' => 'Equal parts intense espresso and silky condensed milk, served warm and full-bodied.',
                'price' => 32000,
                'image' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=600&q=80',
                'ingredients' => 'Ristretto Shot, Condensed Milk, Steamed Whole Milk',
                'calories' => 140,
                'is_available' => true,
                'is_bestseller' => false,
                'is_new' => true,
                'rating' => 4.85,
            ],
            [
                'category_id' => $coffeeCat->id,
                'name' => 'Cold Brew Citrus Breeze',
                'slug' => 'cold-brew-citrus-breeze',
                'description' => '24-hour slow drip Aceh Gayo cold brew infused with fresh lemon juice and elderflower tonic.',
                'price' => 35000,
                'image' => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&w=600&q=80',
                'ingredients' => 'Aceh Gayo Cold Brew Concentrate, Fresh Squeezed Lemon, Elderflower Tonic',
                'calories' => 90,
                'is_available' => true,
                'is_bestseller' => true,
                'is_new' => true,
                'rating' => 4.90,
            ],
            [
                'category_id' => $coffeeCat->id,
                'name' => 'Classic Flat White',
                'slug' => 'classic-flat-white',
                'description' => 'Micro-foamed steamed milk poured over a rich double ristretto shot with fine latte art.',
                'price' => 30000,
                'image' => 'https://images.unsplash.com/photo-1577968897966-3d4325b36b61?auto=format&fit=crop&w=600&q=80',
                'ingredients' => 'Double Ristretto Espresso, Velvet Microfoam Milk',
                'calories' => 120,
                'is_available' => true,
                'is_bestseller' => false,
                'is_new' => false,
                'rating' => 4.80,
            ],

            // Non Coffee
            [
                'category_id' => $nonCoffeeCat->id,
                'name' => 'Kyoto Uji Matcha Latte',
                'slug' => 'kyoto-uji-matcha-latte',
                'description' => 'First-harvest ceremonial grade Uji matcha whisked with bamboo and poured with oat milk.',
                'price' => 38000,
                'image' => 'https://images.unsplash.com/photo-1536256263959-770b48d82b0a?auto=format&fit=crop&w=600&q=80',
                'ingredients' => 'Uji Ceremonial Matcha, Organic Oat Milk, Organic Honey',
                'calories' => 160,
                'is_available' => true,
                'is_bestseller' => true,
                'is_new' => false,
                'rating' => 4.92,
            ],
            [
                'category_id' => $nonCoffeeCat->id,
                'name' => 'Belgian Dark Chocolate Sea Salt',
                'slug' => 'belgian-dark-chocolate-sea-salt',
                'description' => '70% dark Belgian cocoa melted into creamy milk with a touch of pink Himalayan sea salt.',
                'price' => 36000,
                'image' => 'https://images.unsplash.com/photo-1542990253-0d0f5be5f0ed?auto=format&fit=crop&w=600&q=80',
                'ingredients' => '70% Belgian Dark Chocolate, Whole Milk, Himalayan Pink Salt',
                'calories' => 220,
                'is_available' => true,
                'is_bestseller' => false,
                'is_new' => false,
                'rating' => 4.88,
            ],

            // Tea
            [
                'category_id' => $teaCat->id,
                'name' => 'Earl Grey Lavender Cold Elixir',
                'slug' => 'earl-grey-lavender-cold-elixir',
                'description' => 'Bergamot-scented Earl Grey black tea infused with French lavender buds and crystal sugar.',
                'price' => 28000,
                'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=600&q=80',
                'ingredients' => 'Earl Grey Leaf Tea, Dried Lavender Buds, Lemon Slice, Honey',
                'calories' => 70,
                'is_available' => true,
                'is_bestseller' => false,
                'is_new' => true,
                'rating' => 4.78,
            ],

            // Meals
            [
                'category_id' => $mealsCat->id,
                'name' => 'Nasi Goreng Seberang Meja',
                'slug' => 'nasi-goreng-seberang-meja',
                'description' => 'Signature wok-tossed fried rice served with tender grilled chicken satay, sunny egg, and kerupuk.',
                'price' => 45000,
                'image' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&w=600&q=80',
                'ingredients' => 'Jasmine Rice, Marinated Chicken Satay, Free-range Egg, Sambal Matah',
                'calories' => 520,
                'is_available' => true,
                'is_bestseller' => true,
                'is_new' => false,
                'rating' => 4.96,
            ],
            [
                'category_id' => $mealsCat->id,
                'name' => 'Smoked Beef Brioche Club',
                'slug' => 'smoked-beef-brioche-club',
                'description' => 'Toasted butter brioche packed with double smoked beef bacon, sharp cheddar, lettuce, and truffle mayo.',
                'price' => 48000,
                'image' => 'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?auto=format&fit=crop&w=600&q=80',
                'ingredients' => 'Artisan Brioche Bread, Smoked Beef Brisket, Cheddar Cheese, Truffle Sauce',
                'calories' => 480,
                'is_available' => true,
                'is_bestseller' => false,
                'is_new' => true,
                'rating' => 4.86,
            ],

            // Pastry
            [
                'category_id' => $pastryCat->id,
                'name' => 'Butter Almond Croissant',
                'slug' => 'butter-almond-croissant',
                'description' => 'Flaky 72-layer French butter croissant filled with almond frangipane cream and toasted almond flakes.',
                'price' => 32000,
                'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&w=600&q=80',
                'ingredients' => 'French Butter, Almond Flour, Powdered Sugar, Toasted Almonds',
                'calories' => 340,
                'is_available' => true,
                'is_bestseller' => true,
                'is_new' => false,
                'rating' => 4.94,
            ],

            // Dessert
            [
                'category_id' => $dessertCat->id,
                'name' => 'Burnt Basque Cheesecake',
                'slug' => 'burnt-basque-cheesecake',
                'description' => 'Caramelized top cheesecake with a creamy, gooey center infused with Madagascan vanilla bean.',
                'price' => 35000,
                'image' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?auto=format&fit=crop&w=600&q=80',
                'ingredients' => 'Cream Cheese, Heavy Cream, Madagascan Vanilla, Organic Eggs',
                'calories' => 310,
                'is_available' => true,
                'is_bestseller' => true,
                'is_new' => true,
                'rating' => 4.98,
            ],
        ];

        foreach ($menus as $m) {
            Menu::firstOrCreate(['slug' => $m['slug']], $m);
        }
    }
}
