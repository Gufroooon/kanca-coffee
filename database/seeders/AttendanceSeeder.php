<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $staffUsers = User::whereHas('role', function ($q) {
            $q->where('slug', 'staff');
        })->get();

        foreach ($staffUsers as $staff) {
            // Seed past 7 days of attendances
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);

                $status = ($i == 2) ? 'late' : (($i == 5) ? 'permission' : 'present');
                $clockIn = ($status === 'permission') ? null : (($status === 'late') ? '08:15:00' : '06:55:00');
                $clockOut = ($status === 'permission') ? null : '15:05:00';

                Attendance::firstOrCreate([
                    'user_id' => $staff->id,
                    'date' => $date->format('Y-m-d'),
                ], [
                    'clock_in' => $clockIn,
                    'clock_out' => $clockOut,
                    'status' => $status,
                    'clock_in_location' => 'Kanca Coffee Main Bar (-6.2297, 106.8080)',
                    'clock_out_location' => 'Kanca Coffee Main Bar (-6.2297, 106.8080)',
                    'notes' => ($status === 'late') ? 'Traffic bottleneck at Senopati crossing' : (($status === 'permission') ? 'Barista certification workshop' : 'On time shift completed'),
                ]);
            }
        }
    }
}
