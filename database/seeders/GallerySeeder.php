<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $galleries = [
            [
                'title' => 'Warm Wooden Lounge Interiors',
                'image' => 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=800&q=80',
                'category' => 'ambiance',
                'caption' => 'Spacious communal tables designed for connection and focused productivity.',
            ],
            [
                'title' => 'Espresso Extraction in Motion',
                'image' => 'https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=800&q=80',
                'category' => 'coffee',
                'caption' => 'Single-origin espresso extracted at 9 bars of precision pressure.',
            ],
            [
                'title' => 'Acoustic Night at Kanca Stage',
                'image' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=800&q=80',
                'category' => 'event',
                'caption' => 'Bi-weekly acoustic gig bringing local musicians and coffee lovers together.',
            ],
            [
                'title' => 'Barista Pour-over Craft',
                'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=800&q=80',
                'category' => 'coffee',
                'caption' => 'Precision V60 pour over showcasing floral notes of West Java beans.',
            ],
            [
                'title' => 'Freshly Baked Croissant Display',
                'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&w=800&q=80',
                'category' => 'ambiance',
                'caption' => 'Morning freshly baked French pastries prepared daily at 6:00 AM.',
            ],
            [
                'title' => 'Community Gathering & Workshops',
                'image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=800&q=80',
                'category' => 'community',
                'caption' => 'Friends connecting over specialty coffee and shared ideas.',
            ],
        ];

        foreach ($galleries as $g) {
            Gallery::firstOrCreate(['title' => $g['title']], $g);
        }
    }
}
