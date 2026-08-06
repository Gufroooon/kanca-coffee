<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Feedback;
use App\Models\Menu;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalMenus = Menu::count();
        $totalEvents = Event::count();
        $totalUsers = User::count();
        $todayAttendances = Attendance::where('date', Carbon::today()->toDateString())->count();
        $totalRegistrations = EventRegistration::count();
        $pendingFeedbacks = Feedback::where('status', 'published')->count();

        $recentRegistrations = EventRegistration::with('event')->orderBy('registered_at', 'desc')->take(5)->get();
        $recentAttendances = Attendance::with('user')->where('date', Carbon::today()->toDateString())->orderBy('clock_in', 'desc')->take(5)->get();

        // Chart Data (Last 7 days attendance)
        $chartDates = [];
        $chartAttendanceData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $chartDates[] = Carbon::today()->subDays($i)->format('D, M d');
            $chartAttendanceData[] = Attendance::where('date', $date)->count();
        }

        return view('admin.dashboard', compact(
            'totalMenus',
            'totalEvents',
            'totalUsers',
            'todayAttendances',
            'totalRegistrations',
            'pendingFeedbacks',
            'recentRegistrations',
            'recentAttendances',
            'chartDates',
            'chartAttendanceData'
        ));
    }
}
