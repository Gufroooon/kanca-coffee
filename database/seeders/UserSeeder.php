<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $staffRole = Role::where('slug', 'staff')->first();
        $userRole = Role::where('slug', 'user')->first();

        // 1. Admin User
        User::firstOrCreate(
            ['email' => 'admin@kancacoffee.com'],
            [
                'role_id' => $adminRole->id,
                'name' => 'Kanca Admin Master',
                'phone' => '081234567890',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80',
                'shift' => 'All Shifts',
                'is_active' => true,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Staff Users
        $staffMembers = [
            [
                'name' => 'Dimas Barista Lead',
                'email' => 'staff@kancacoffee.com',
                'phone' => '081298765432',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80',
                'shift' => 'Morning Shift (07:00 - 15:00)',
            ],
            [
                'name' => 'Siti Roaster Pro',
                'email' => 'siti.barista@kancacoffee.com',
                'phone' => '081311223344',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=300&q=80',
                'shift' => 'Evening Shift (15:00 - 23:00)',
            ],
            [
                'name' => 'Budi Floor Captain',
                'email' => 'budi.staff@kancacoffee.com',
                'phone' => '081355667788',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=80',
                'shift' => 'Morning Shift (07:00 - 15:00)',
            ],
        ];

        foreach ($staffMembers as $staffData) {
            User::firstOrCreate(
                ['email' => $staffData['email']],
                array_merge($staffData, [
                    'role_id' => $staffRole->id,
                    'is_active' => true,
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ])
            );
        }

        // 3. Public Users
        $publicUsers = [
            [
                'name' => 'Rian Community Member',
                'email' => 'user@kancacoffee.com',
                'phone' => '081499887766',
                'avatar' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=300&q=80',
            ],
            [
                'name' => 'Anisa Creative Designer',
                'email' => 'anisa@gmail.com',
                'phone' => '081522334455',
                'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=300&q=80',
            ],
        ];

        foreach ($publicUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                array_merge($userData, [
                    'role_id' => $userRole->id,
                    'is_active' => true,
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ])
            );
        }
    }
}
