<?php

namespace App\Http\Controllers;

use App\Repositories\AttendanceRepository;
use App\Services\AttendanceService;
use App\Models\Menu;
use App\Models\Order;
use Carbon\Carbon;
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

        // Fetch available menus for ordering
        $menus = Menu::where('is_available', true)->orderBy('name', 'asc')->get();

        // Fetch today's orders
        $todayOrders = Order::with(['items.menu', 'user'])
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->get();

        return view('staff.dashboard', compact('user', 'todayAttendance', 'monthlyHistory', 'menus', 'todayOrders'));
    }

    public function clockIn(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'accuracy' => 'nullable|numeric|min:0|max:10000',
            'notes' => 'nullable|string|max:2000',
        ]);

        try {
            $this->attendanceService->clockIn($user, (float) $validated['latitude'], (float) $validated['longitude'], isset($validated['accuracy']) ? (float) $validated['accuracy'] : null, $validated['notes'] ?? null);

            return back()->with('success', 'Successfully Clocked In! Work safely today.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function clockOut(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'accuracy' => 'nullable|numeric|min:0|max:10000',
            'notes' => 'nullable|string|max:2000',
        ]);

        try {
            $this->attendanceService->clockOut($user, (float) $validated['latitude'], (float) $validated['longitude'], isset($validated['accuracy']) ? (float) $validated['accuracy'] : null, $validated['notes'] ?? null);

            return back()->with('success', 'Successfully Clocked Out! Thank you for your hard work today.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
