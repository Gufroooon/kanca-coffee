<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\AttendanceLog;
use App\Models\User;
use Carbon\Carbon;

class AttendanceService
{
    public function clockIn(User $user, ?string $location = null, ?string $notes = null): Attendance
    {
        $today = Carbon::today()->toDateString();
        $nowTime = Carbon::now()->format('H:i:s');

        // Determine if late (e.g. shift starts at 07:00 or 15:00)
        $isLate = false;
        $nowHour = (int) Carbon::now()->format('H');
        $nowMinute = (int) Carbon::now()->format('i');

        if (str_contains($user->shift, 'Morning') && ($nowHour > 7 || ($nowHour === 7 && $nowMinute > 15))) {
            $isLate = true;
        } elseif (str_contains($user->shift, 'Evening') && ($nowHour > 15 || ($nowHour === 15 && $nowMinute > 15))) {
            $isLate = true;
        }

        $attendance = Attendance::updateOrCreate(
            ['user_id' => $user->id, 'date' => $today],
            [
                'clock_in' => $nowTime,
                'status' => $isLate ? 'late' : 'present',
                'clock_in_location' => $location ?? 'Kanca Coffee Store (-6.2297, 106.8080)',
                'notes' => $notes,
            ]
        );

        AttendanceLog::create([
            'attendance_id' => $attendance->id,
            'action' => 'clock_in',
            'note' => "Clock in recorded at {$nowTime}" . ($isLate ? ' (Marked Late)' : ''),
        ]);

        return $attendance;
    }

    public function clockOut(User $user, ?string $location = null, ?string $notes = null): Attendance
    {
        $today = Carbon::today()->toDateString();
        $nowTime = Carbon::now()->format('H:i:s');

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->firstOrFail();

        $attendance->update([
            'clock_out' => $nowTime,
            'clock_out_location' => $location ?? 'Kanca Coffee Store (-6.2297, 106.8080)',
            'notes' => $notes ? ($attendance->notes ? $attendance->notes . ' | Out note: ' . $notes : $notes) : $attendance->notes,
        ]);

        AttendanceLog::create([
            'attendance_id' => $attendance->id,
            'action' => 'clock_out',
            'note' => "Clock out recorded at {$nowTime}",
        ]);

        return $attendance;
    }
}
