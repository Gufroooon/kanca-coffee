<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Aditya Pratama',
                'role' => 'Tech Lead & Freelancer',
                'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=200&q=80',
                'message' => 'Kanca Coffee standardizes fast Wi-Fi, electric sockets at every single seat, and signature Aren Latte that fuels my remote work routines!',
                'rating' => 5,
                'is_featured' => true,
            ],
            [
                'name' => 'Maya Indah',
                'role' => 'Community Organizer',
                'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=200&q=80',
                'message' => 'The tagline "Teman yang kamu cari ada di seberang meja" is 100% real. I met my co-founder during one of Kanca’s open mic coffee classes!',
                'rating' => 5,
                'is_featured' => true,
            ],
            [
                'name' => 'Randi Kurniawan',
                'role' => 'Coffee Enthusiast',
                'avatar' => 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?auto=format&fit=crop&w=200&q=80',
                'message' => 'Their Aceh Gayo Cold Brew Citrus is hands down the best specialty coffee innovation in town. Staff attendance & service is exceptionally warm.',
                'rating' => 5,
                'is_featured' => true,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::firstOrCreate(['name' => $t['name']], $t);
        }
    }
}
