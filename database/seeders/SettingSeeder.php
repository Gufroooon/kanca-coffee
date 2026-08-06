<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'KANCA COFFEE', 'group' => 'general'],
            ['key' => 'tagline', 'value' => 'Teman yang kamu cari ada di seberang meja.', 'group' => 'general'],
            ['key' => 'contact_whatsapp', 'value' => '+6281234567890', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'hello@kancacoffee.com', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'Jl. Senopati No. 42, Kebayoran Baru, Jakarta Selatan', 'group' => 'contact'],
            ['key' => 'weekday_hours', 'value' => '07:00 - 23:00 WIB', 'group' => 'hours'],
            ['key' => 'weekend_hours', 'value' => '07:00 - 24:00 WIB', 'group' => 'hours'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/kancacoffee', 'group' => 'social'],
            ['key' => 'gofood_url', 'value' => 'https://gofood.link/kancacoffee', 'group' => 'social'],
            ['key' => 'shopeefood_url', 'value' => 'https://shopeefood.link/kancacoffee', 'group' => 'social'],
            ['key' => 'announcement_banner', 'value' => '☕ Free Speciality Cookie for every Signature Aren Latte on Weekdays 14:00 - 17:00!', 'group' => 'general'],
        ];

        foreach ($settings as $s) {
            Setting::firstOrCreate(['key' => $s['key']], $s);
        }
    }
}
