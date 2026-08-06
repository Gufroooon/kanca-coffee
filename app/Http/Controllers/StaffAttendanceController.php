<?php

namespace App\Http\Controllers;

use App\Repositories\AttendanceRepository;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffAttendanceController extends Controller
{
    protected $attendanceRepo;
    protected $attendanceService;

    public function __construct(AttendanceRepository $attendanceRepo, AttendanceService $attendanceService)
    {
        $this->attendanceRepo = $attendanceRepo;
        $this->attendanceService = $attendanceService;
    }

    public function index()
    {
        $user = Auth::user();
        $todayAttendance = $this->attendanceRepo->getTodayAttendance($user->id);
        $monthlyHistory = $this->attendanceRepo->getUserMonthlyAttendance($user->id);

        return view('staff.dashboard', compact('user', 'todayAttendance', 'monthlyHistory'));
    }

    public function clockIn(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'location' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        try {
            $this->attendanceService->clockIn($user, $validated['location'] ?? null, $validated['notes'] ?? null);

            return back()->with('success', 'Successfully Clocked In! Work safely today.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function clockOut(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'location' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        try {
            $this->attendanceService->clockOut($user, $validated['location'] ?? null, $validated['notes'] ?? null);

            return back()->with('success', 'Successfully Clocked Out! Thank you for your hard work today.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
