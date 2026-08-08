<?php

namespace App\Repositories;

use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceRepository
{
    public function getTodayAttendance(int $userId)
    {
        $active = Attendance::where('user_id', $userId)
            ->whereNull('clock_out')
            ->latest('id')
            ->first();

        if ($active) {
            return $active;
        }

        return Attendance::where('user_id', $userId)
            ->where('date', Carbon::today()->toDateString())
            ->latest('id')
            ->first();
    }

    public function getUserMonthlyAttendance(int $userId, ?int $month = null, ?int $year = null)
    {
        $month = $month ?? Carbon::now()->month;
        $year = $year ?? Carbon::now()->year;

        return Attendance::where('user_id', $userId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->get();
    }

    public function getAdminFilteredAttendance(?string $date = null, ?int $userId = null)
    {
        $query = Attendance::with('user');

        if ($date) {
            $query->where('date', $date);
        }

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->orderBy('date', 'desc')->paginate(15)->withQueryString();
    }
}
