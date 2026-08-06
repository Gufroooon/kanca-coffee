<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Services\AttendanceExportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AdminAttendanceController extends Controller
{
    private function filteredQuery(Request $request)
    {
        $validated = $request->validate([
            'date' => ['nullable', 'date'], // Backward-compatible single-date filter.
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'status' => ['nullable', 'in:present,late,leave,permission'],
        ]);

        $query = Attendance::with('user');

        if (! empty($validated['date'])) {
            $query->whereDate('date', $validated['date']);
        } else {
            if (! empty($validated['date_from'])) {
                $query->whereDate('date', '>=', $validated['date_from']);
            }

            if (! empty($validated['date_to'])) {
                $query->whereDate('date', '<=', $validated['date_to']);
            }
        }

        if (! empty($validated['user_id'])) {
            $query->where('user_id', $validated['user_id']);
        }

        if (! empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $attendances = $this->filteredQuery($request)->orderBy('date', 'desc')->paginate(15)->withQueryString();
        $staffList = User::whereHas('role', function ($q) {
            $q->where('slug', 'staff');
        })->get();

        return view('admin.attendances.index', compact('attendances', 'staffList'));
    }

    public function exportPdf(Request $request)
    {
        $attendances = $this->filteredQuery($request)->orderBy('date', 'desc')->get();
        $generatedAt = now()->format('d M Y H:i');

        $pdf = Pdf::loadView('admin.attendances.pdf', compact('attendances', 'generatedAt'));

        return $pdf->download('Kanca_Coffee_Attendance_Report_'.date('Y_m_d').'.pdf');
    }

    public function exportExcel(Request $request, AttendanceExportService $exportService)
    {
        $attendances = $this->filteredQuery($request)->orderBy('date', 'desc')->get();

        return $exportService->download($attendances);
    }
}
