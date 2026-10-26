<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class HRReportController extends Controller
{
    public function attendance(Request $request): View
    {
        $filters = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'status' => ['nullable', 'in:present,late,permission,sick,absent'],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $startDate = $filters['start_date']
            ?? now()->startOfMonth()->toDateString();

        $endDate = $filters['end_date']
            ?? now()->toDateString();

        $query = Attendance::query()
            ->with(['employee.department'])
            ->whereBetween('attendance_date', [$startDate, $endDate]);

        if (!empty($filters['department_id'])) {
            $query->whereHas('employee', function ($employeeQuery) use ($filters) {
                $employeeQuery->where('department_id', $filters['department_id']);
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->whereHas('employee', function ($employeeQuery) use ($search) {
                $employeeQuery->where(function ($subQuery) use ($search) {
                    $subQuery->where('full_name', 'like', "%{$search}%")
                        ->orWhere('employee_number', 'like', "%{$search}%");
                });
            });
        }

        $summary = (clone $query)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $attendances = $query
            ->orderByDesc('attendance_date')
            ->orderBy('employee_id')
            ->paginate(15)
            ->withQueryString();

        return view('reports.attendance', [
            'attendances' => $attendances,
            'departments' => Department::orderBy('name')->get(),
            'filters' => $filters,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'summary' => [
                'present' => (int) ($summary['present'] ?? 0),
                'late' => (int) ($summary['late'] ?? 0),
                'permission' => (int) ($summary['permission'] ?? 0),
                'sick' => (int) ($summary['sick'] ?? 0),
                'absent' => (int) ($summary['absent'] ?? 0),
            ],
        ]);
    }

    public function exportAttendance(Request $request): StreamedResponse
    {
        $filters = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'status' => ['nullable', 'in:present,late,permission,sick,absent'],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $startDate = $filters['start_date']
            ?? now()->startOfMonth()->toDateString();

        $endDate = $filters['end_date']
            ?? now()->toDateString();

        $query = Attendance::query()
            ->with(['employee.department'])
            ->whereBetween('attendance_date', [$startDate, $endDate]);

        if (!empty($filters['department_id'])) {
            $query->whereHas('employee', function ($employeeQuery) use ($filters) {
                $employeeQuery->where('department_id', $filters['department_id']);
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->whereHas('employee', function ($employeeQuery) use ($search) {
                $employeeQuery->where(function ($subQuery) use ($search) {
                    $subQuery->where('full_name', 'like', "%{$search}%")
                        ->orWhere('employee_number', 'like', "%{$search}%");
                });
            });
        }

        $filename = "laporan-absensi-{$startDate}-{$endDate}.csv";

        return response()->streamDownload(function () use ($query) {
            $output = fopen('php://output', 'w');

            // BOM agar teks UTF-8 terbaca dengan baik di Excel.
            fwrite($output, "\xEF\xBB\xBF");


            fputcsv($output, [
                'Tanggal',
                'Nomor Karyawan',
                'Nama Karyawan',
                'Departemen',
                'Status',
                'Jam Masuk',
                'Jam Keluar',
                'Catatan',
            ], ',');

            $query->orderBy('attendance_date')
                ->orderBy('employee_id')
                ->chunk(500, function ($rows) use ($output) {
                    foreach ($rows as $attendance) {
                        fputcsv($output, [
                            optional($attendance->attendance_date)->format('Y-m-d')
                                ?? $attendance->attendance_date,
                            $attendance->employee?->employee_number ?? '',
                            $attendance->employee?->full_name ?? '',
                            $attendance->employee?->department?->name ?? '',
                            $attendance->status,
                            $attendance->check_in,
                            $attendance->check_out,
                            $attendance->notes,
                        ], ',');
                    }
                });

            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
