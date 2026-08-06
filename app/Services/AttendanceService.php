<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\AttendanceLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    public function clockIn(User $user, float $latitude, float $longitude, ?float $accuracy = null, ?string $notes = null): Attendance
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

        return DB::transaction(function () use ($user, $today, $nowTime, $isLate, $latitude, $longitude, $accuracy, $notes) {
            $attendance = Attendance::query()->where('user_id', $user->id)->where('date', $today)->latest('id')->lockForUpdate()->first();
            if ($attendance?->clock_in) {
                throw new \Exception('You have already clocked in today.');
            }

            $data = ['clock_in' => $nowTime, 'status' => $isLate ? 'late' : 'present', 'clock_in_location' => $this->formatLocation($latitude, $longitude, $accuracy), 'clock_in_latitude' => $latitude, 'clock_in_longitude' => $longitude, 'clock_in_accuracy' => $accuracy, 'notes' => $notes];
            $attendance = $attendance ? tap($attendance)->update($data) : Attendance::create(array_merge(['user_id' => $user->id, 'date' => $today], $data));

            AttendanceLog::create(['attendance_id' => $attendance->id, 'action' => 'clock_in', 'note' => "Clock in recorded at {$nowTime}".($isLate ? ' (Marked Late)' : '')]);

            return $attendance;
        });
    }

    public function clockOut(User $user, float $latitude, float $longitude, ?float $accuracy = null, ?string $notes = null): Attendance
    {
        $today = Carbon::today()->toDateString();
        $nowTime = Carbon::now()->format('H:i:s');

        return DB::transaction(function () use ($user, $today, $nowTime, $latitude, $longitude, $accuracy, $notes) {
            $attendance = Attendance::query()->where('user_id', $user->id)->where('date', $today)->latest('id')->lockForUpdate()->firstOrFail();
            if (! $attendance->clock_in) {
                throw new \Exception('Please clock in before clocking out.');
            }
            if ($attendance->clock_out) {
                throw new \Exception('You have already clocked out today.');
            }

            $attendance->update(['clock_out' => $nowTime, 'clock_out_location' => $this->formatLocation($latitude, $longitude, $accuracy), 'clock_out_latitude' => $latitude, 'clock_out_longitude' => $longitude, 'clock_out_accuracy' => $accuracy, 'notes' => $notes ? ($attendance->notes ? $attendance->notes.' | Out note: '.$notes : $notes) : $attendance->notes]);
            AttendanceLog::create(['attendance_id' => $attendance->id, 'action' => 'clock_out', 'note' => "Clock out recorded at {$nowTime}"]);

            return $attendance;
        });
    }

    private function formatLocation(float $latitude, float $longitude, ?float $accuracy): string
    {
        return sprintf('%.6F, %.6F%s', $latitude, $longitude, $accuracy !== null ? sprintf(' (±%.0f m)', $accuracy) : '');
    }
}
