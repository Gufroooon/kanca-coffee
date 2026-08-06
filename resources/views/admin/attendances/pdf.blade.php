<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kanca Coffee - Attendance Report</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #232323; margin: 0; padding: 20px; }
        .header { border-bottom: 2px solid #EB5724; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { color: #EB5724; font-size: 24px; margin: 0 0 5px 0; }
        .header p { margin: 0; color: #666; font-size: 11px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table th, .table td { border: 1px solid #e2e8f0; padding: 8px 10px; text-align: left; }
        .table th { background-color: #FFF8F5; color: #232323; font-weight: bold; }
        .badge { padding: 3px 8px; border-radius: 12px; font-size: 10px; font-weight: bold; text-transform: uppercase; display: inline-block; }
        .badge-present { background-color: #d1fae5; color: #065f46; }
        .badge-late { background-color: #fef3c7; color: #92400e; }
        .badge-permission { background-color: #e0e7ff; color: #3730a3; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #888; }
    </style>
</head>
<body>
    <div class="header">
        <h1>KANCA COFFEE</h1>
        <p>Official Employee Attendance Report & Monthly Audit Logs</p>
        <p>Generated At: {{ $generatedAt }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Employee Name</th>
                <th>Shift</th>
                <th>Clock In</th>
                <th>Clock Out</th>
                <th>Status</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $item)
                <tr>
                    <td>{{ $item->date ? $item->date->format('d M Y') : '-' }}</td>
                    <td><strong>{{ $item->user ? $item->user->name : 'N/A' }}</strong></td>
                    <td>{{ $item->user ? $item->user->shift : 'N/A' }}</td>
                    <td>{{ $item->clock_in ?? '-' }}</td>
                    <td>{{ $item->clock_out ?? '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $item->status }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>{{ $item->notes ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #888;">No attendance records found for the selected period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Kanca Coffee Management System &copy; {{ date('Y') }}</p>
    </div>
</body>
</html>
