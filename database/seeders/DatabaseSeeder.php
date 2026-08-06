<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            MenuSeeder::class,
            EventSeeder::class,
            TestimonialSeeder::class,
            GallerySeeder::class,
            SettingSeeder::class,
            AttendanceSeeder::class,
        ]);
    }
}
