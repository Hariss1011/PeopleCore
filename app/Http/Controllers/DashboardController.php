<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $isEmployee = $user->role === 'employee';
        $canViewReports = in_array($user->role, ['admin', 'hr']);

        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
        ]);

        $startDate = $validated['start_date']
            ?? now()->startOfMonth()->toDateString();

        $endDate = $validated['end_date']
            ?? now()->toDateString();

        $departmentId = $validated['department_id'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | Statistik karyawan
        |--------------------------------------------------------------------------
        */

        $employeeQuery = Employee::query();

        if ($departmentId && $canViewReports) {
            $employeeQuery->where('department_id', $departmentId);
        }

        // Mendukung skema yang memakai kolom status atau employment_status.
        $employeeColumns = Schema::getColumnListing('employees');

        $statusColumn = collect(['status', 'employment_status'])
            ->first(fn($column) => in_array($column, $employeeColumns));

        if ($statusColumn) {
            $employeeQuery->whereIn(
                DB::raw("LOWER(`{$statusColumn}`)"),
                ['active', 'aktif']
            );
        }

        $activeEmployees = $employeeQuery->count();

        $departmentsQuery = Department::query();

        if ($departmentId && $canViewReports) {
            $departmentsQuery->where('id', $departmentId);
        }

        $departments = $departmentsQuery
            ->withCount([
                'employees' => function ($query) use ($statusColumn) {
                    if ($statusColumn) {
                        $query->whereIn(
                            DB::raw("LOWER(`{$statusColumn}`)"),
                            ['active', 'aktif']
                        );
                    }
                },
            ])
            ->orderBy('name')
            ->get();

        $departmentCount = Department::count();

        /*
        |--------------------------------------------------------------------------
        | Filter absensi
        |--------------------------------------------------------------------------
        */

        $attendanceQuery = Attendance::query()
            ->whereBetween('attendance_date', [$startDate, $endDate]);

        if ($isEmployee) {
            $attendanceQuery->where('employee_id', $user->employee_id);
        } elseif ($departmentId) {
            $attendanceQuery->whereHas('employee', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            });
        }

        $attendanceByStatus = (clone $attendanceQuery)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $attendanceTotal = (clone $attendanceQuery)->count();

        $attendanceStats = [
            'present' => (int) ($attendanceByStatus['present'] ?? 0),
            'late' => (int) ($attendanceByStatus['late'] ?? 0),
            'permission' => (int) ($attendanceByStatus['permission'] ?? 0),
            'sick' => (int) ($attendanceByStatus['sick'] ?? 0),
            'absent' => (int) ($attendanceByStatus['absent'] ?? 0),
        ];

        /*
        |--------------------------------------------------------------------------
        | Tren absensi enam bulan terakhir
        |--------------------------------------------------------------------------
        */

        $trendLabels = [];
        $trendPresent = [];
        $trendLate = [];
        $trendAbsent = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->startOfMonth()->subMonths($i);

            $trendLabels[] = $month->translatedFormat('M Y');

            $monthQuery = Attendance::query()
                ->whereYear('attendance_date', $month->year)
                ->whereMonth('attendance_date', $month->month);

            if ($isEmployee) {
                $monthQuery->where('employee_id', $user->employee_id);
            } elseif ($departmentId) {
                $monthQuery->whereHas('employee', function ($query) use ($departmentId) {
                    $query->where('department_id', $departmentId);
                });
            }

            $monthStats = (clone $monthQuery)
                ->select('status', DB::raw('COUNT(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status');

            $trendPresent[] = (int) ($monthStats['present'] ?? 0);
            $trendLate[] = (int) ($monthStats['late'] ?? 0);
            $trendAbsent[] = (int) ($monthStats['absent'] ?? 0);
        }

        /*
        |--------------------------------------------------------------------------
        | Statistik pengajuan cuti
        |--------------------------------------------------------------------------
        */

        $leaveQuery = LeaveRequest::query();

        if ($isEmployee) {
            $leaveQuery->where('employee_id', $user->employee_id);
        } elseif ($departmentId) {
            $leaveQuery->whereHas('employee', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            });
        }

        $leaveByStatus = (clone $leaveQuery)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $leaveStats = [
            'pending' => (int) ($leaveByStatus['pending'] ?? 0),
            'approved' => (int) ($leaveByStatus['approved'] ?? 0),
            'rejected' => (int) ($leaveByStatus['rejected'] ?? 0),
        ];

        return view('dashboard', [
            'user' => $user,
            'isEmployee' => $isEmployee,
            'canViewReports' => $canViewReports,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'departmentId' => $departmentId,
            'departments' => $departments,
            'activeEmployees' => $activeEmployees,
            'departmentCount' => $departmentCount,
            'attendanceTotal' => $attendanceTotal,
            'attendanceStats' => $attendanceStats,
            'leaveStats' => $leaveStats,
            'trendLabels' => $trendLabels,
            'trendPresent' => $trendPresent,
            'trendLate' => $trendLate,
            'trendAbsent' => $trendAbsent,
        ]);
    }
}
