<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'Artisan Manual Brew Workshop & Sensory Cupping',
                'slug' => 'artisan-manual-brew-workshop',
                'description' => 'Master V60, AeroPress, and Chemex extraction techniques under the guidance of certified Q-Grader baristas. Includes hands-on cupping session with single-origin beans.',
                'date' => now()->addDays(5)->format('Y-m-d'),
                'start_time' => '15:00',
                'end_time' => '18:00',
                'location' => 'Kanca Brew Lab & Main Stage',
                'capacity' => 20,
                'registered_count' => 14,
                'poster' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=800&q=80',
                'price' => 75000,
                'speaker_name' => 'Fajar Nugraha',
                'speaker_title' => 'Certified Q-Grader & Head Roaster',
                'status' => 'upcoming',
                'is_featured' => true,
            ],
            [
                'title' => 'Acoustic Sunset Mini Gig: Indie Vibes Vol. 14',
                'slug' => 'acoustic-sunset-mini-gig-indie-vibes-vol-14',
                'description' => 'Unwind your weekend with intimate acoustic live performances by local indie musicians, accompanied by signature mocktails and artisan coffee.',
                'date' => now()->addDays(9)->format('Y-m-d'),
                'start_time' => '19:00',
                'end_time' => '22:00',
                'location' => 'Kanca Outdoor Garden Terrace',
                'capacity' => 60,
                'registered_count' => 42,
                'poster' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=800&q=80',
                'price' => 0,
                'speaker_name' => 'Senja & The Table',
                'speaker_title' => 'Indie Folk Collective',
                'status' => 'upcoming',
                'is_featured' => true,
            ],
            [
                'title' => 'Kanca Youth Creative Market & Thrift Bazaar',
                'slug' => 'kanca-youth-creative-market',
                'description' => 'A vibrant weekend pop-up gathering local craft makers, vintage fashion curations, handmade ceramics, and art printmakers.',
                'date' => now()->addDays(14)->format('Y-m-d'),
                'start_time' => '10:00',
                'end_time' => '18:00',
                'location' => 'Kanca Community Pavilion',
                'capacity' => 100,
                'registered_count' => 65,
                'poster' => 'https://images.unsplash.com/photo-1531058020387-3be344556be6?auto=format&fit=crop&w=800&q=80',
                'price' => 0,
                'speaker_name' => 'Kanca Community Hub',
                'speaker_title' => 'Youth Entrepreneur Network',
                'status' => 'upcoming',
                'is_featured' => true,
            ],
            [
                'title' => 'Latte Art Pouring Masterclass for Beginners',
                'slug' => 'latte-art-pouring-masterclass',
                'description' => 'Learn milk steaming texture science, heart, tulip, and rosetta pouring patterns directly on commercial dual-boiler espresso machines.',
                'date' => now()->addDays(20)->format('Y-m-d'),
                'start_time' => '14:00',
                'end_time' => '17:00',
                'location' => 'Kanca Espresso Bar',
                'capacity' => 12,
                'registered_count' => 8,
                'poster' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=800&q=80',
                'price' => 120000,
                'speaker_name' => 'Dimas Lead Barista',
                'speaker_title' => 'National Latte Art Finalist',
                'status' => 'upcoming',
                'is_featured' => false,
            ],
            [
                'title' => 'Open Mic Poetry & Standup Night',
                'slug' => 'open-mic-poetry-standup-night',
                'description' => 'Take the mic seberang meja! Express your poetry, storytelling, or standup comedy jokes in a warm, welcoming community environment.',
                'date' => now()->addDays(25)->format('Y-m-d'),
                'start_time' => '19:30',
                'end_time' => '22:00',
                'location' => 'Kanca Amphitheater Corner',
                'capacity' => 45,
                'registered_count' => 20,
                'poster' => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?auto=format&fit=crop&w=800&q=80',
                'price' => 0,
                'speaker_name' => 'Open Mic Community',
                'speaker_title' => 'Public Performers',
                'status' => 'upcoming',
                'is_featured' => false,
            ],
        ];

        foreach ($events as $ev) {
            Event::firstOrCreate(['slug' => $ev['slug']], $ev);
        }
    }
}
