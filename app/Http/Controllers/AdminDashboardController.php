<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Cashflow;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Feedback;
use App\Models\Ingredient;
use App\Models\InventoryLog;
use App\Models\Menu;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalMenus = Menu::count();
        $totalEvents = Event::count();
        $totalUsers = User::count();
        $todayAttendances = Attendance::where('date', Carbon::today()->toDateString())->count();
        $totalRegistrations = EventRegistration::count();
        $pendingFeedbacks = Feedback::where('status', 'published')->count();

        $recentRegistrations = EventRegistration::with('event')->orderBy('registered_at', 'desc')->take(5)->get();
        $recentAttendances = Attendance::with('user')->where('date', Carbon::today()->toDateString())->orderBy('clock_in', 'desc')->take(5)->get();

        $today = Carbon::today();
        $monthStart = Carbon::now()->startOfMonth();
        $totalIngredients = Ingredient::where('is_active', true)->count();
        $totalStock = Ingredient::where('is_active', true)->sum('current_stock');
        $todayUsage = InventoryLog::whereDate('log_date', $today)->sum('usage');
        $lowStockIngredients = Ingredient::where('is_active', true)->whereColumn('current_stock', '<=', 'minimum_stock')->orderBy('current_stock')->get();
        $todayIncome = Cashflow::where('type', 'income')->whereDate('transaction_date', $today)->sum('amount');
        $todayExpense = Cashflow::where('type', 'expense')->whereDate('transaction_date', $today)->sum('amount');
        $monthIncome = Cashflow::where('type', 'income')->whereBetween('transaction_date', [$monthStart->toDateString(), $today->toDateString()])->sum('amount');
        $monthExpense = Cashflow::where('type', 'expense')->whereBetween('transaction_date', [$monthStart->toDateString(), $today->toDateString()])->sum('amount');
        $todayTransactions = Cashflow::whereDate('transaction_date', $today)->count();
        $todayInventoryLogs = InventoryLog::whereDate('log_date', $today)->count();
        $recentInventoryLogs = InventoryLog::with('ingredient')->latest('log_date')->latest('id')->take(5)->get();

        $financialTrend = Cashflow::select('transaction_date', 'type', DB::raw('SUM(amount) as total'))
            ->whereDate('transaction_date', '>=', $today->copy()->subDays(6))
            ->groupBy('transaction_date', 'type')->orderBy('transaction_date')->get();
        $financialDates = collect();
        $incomeTrend = collect();
        $expenseTrend = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $key = $date->toDateString();
            $financialDates->push($date->format('d M'));
            $incomeTrend->push((float) ($financialTrend->first(fn ($row) => $row->transaction_date === $key && $row->type === 'income')->total ?? 0));
            $expenseTrend->push((float) ($financialTrend->first(fn ($row) => $row->transaction_date === $key && $row->type === 'expense')->total ?? 0));
        }

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
            'chartAttendanceData',
            'totalIngredients', 'totalStock', 'todayUsage', 'lowStockIngredients',
            'todayIncome', 'todayExpense', 'monthIncome', 'monthExpense',
            'todayTransactions', 'todayInventoryLogs', 'recentInventoryLogs',
            'financialDates', 'incomeTrend', 'expenseTrend'
        ));
    }
}
