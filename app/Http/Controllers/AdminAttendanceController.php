<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('user');

        if ($request->has('date') && $request->date) {
            $query->where('date', $request->date);
        }

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(15)->withQueryString();
        $staffList = User::whereHas('role', function ($q) {
            $q->where('slug', 'staff');
        })->get();

        return view('admin.attendances.index', compact('attendances', 'staffList'));
    }

    public function exportPdf(Request $request)
    {
        $query = Attendance::with('user');

        if ($request->has('date') && $request->date) {
            $query->where('date', $request->date);
        }

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $attendances = $query->orderBy('date', 'desc')->get();
        $generatedAt = now()->format('d M Y H:i');

        $pdf = Pdf::loadView('admin.attendances.pdf', compact('attendances', 'generatedAt'));
        return $pdf->download('Kanca_Coffee_Attendance_Report_' . date('Y_m_d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = Attendance::with('user');

        if ($request->has('date') && $request->date) {
            $query->where('date', $request->date);
        }

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        $filename = 'Kanca_Coffee_Attendance_Report_' . date('Y_m_d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($attendances) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Date', 'Employee Name', 'Shift', 'Clock In', 'Clock Out', 'Status', 'Notes']);

            foreach ($attendances as $row) {
                fputcsv($file, [
                    $row->id,
                    $row->date ? $row->date->format('Y-m-d') : '',
                    $row->user ? $row->user->name : 'N/A',
                    $row->user ? $row->user->shift : 'N/A',
                    $row->clock_in ?? '-',
                    $row->clock_out ?? '-',
                    strtoupper($row->status),
                    $row->notes ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
