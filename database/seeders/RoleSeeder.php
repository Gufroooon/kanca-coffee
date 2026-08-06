<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'Full control over application, menus, events, attendance, employees, users, and reports.',
            ],
            [
                'name' => 'Staff',
                'slug' => 'staff',
                'description' => 'Barista and floor staff who manage daily shift clock-in/out and view work schedules.',
            ],
            [
                'name' => 'Public User',
                'slug' => 'user',
                'description' => 'Community member who can register for events, favorite menus, and send feedback.',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
