<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;


class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'status' => ['nullable', 'in:present,late,permission,sick,absent'],
            'date_from' => ['nullable', 'date'],
            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],
        ]);

        $query = Attendance::with([
            'employee.department',
            'recorder',
        ]);

        $query
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->whereHas('employee', function ($employeeQuery) use ($search) {
                    $employeeQuery->where(function ($subQuery) use ($search) {
                        $subQuery->where('full_name', 'like', "%{$search}%")
                            ->orWhere('employee_number', 'like', "%{$search}%");
                    });
                });
            })
            ->when($request->filled('department_id'), function ($query) use ($request) {
                $query->whereHas('employee', function ($employeeQuery) use ($request) {
                    $employeeQuery->where(
                        'department_id',
                        $request->department_id
                    );
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('date_from'), function ($query) use ($request) {
                $query->whereDate(
                    'attendance_date',
                    '>=',
                    $request->date_from
                );
            })
            ->when($request->filled('date_to'), function ($query) use ($request) {
                $query->whereDate(
                    'attendance_date',
                    '<=',
                    $request->date_to
                );
            });

        $summary = (clone $query)
            ->reorder()
            ->selectRaw("
                COUNT(*) as total,
                SUM(status = 'present') as present,
                SUM(status = 'late') as late,
                SUM(status = 'permission') as permission,
                SUM(status = 'sick') as sick,
                SUM(status = 'absent') as absent
            ")
            ->first();

        $attendances = $query
            ->orderByDesc('attendance_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $departments = Department::orderBy('name')->get();

        return view('attendances.index', compact(
            'attendances',
            'departments',
            'summary'
        ));
    }


    public function create()
    {
        $employees = Employee::with('department')
            ->orderBy('full_name')
            ->get();

        return view('attendances.create', compact('employees'));
    }

    public function store(StoreAttendanceRequest $request)
    {
        $data = $request->validated();

        $data['recorded_by'] = $request->user()->id;

        try {
            DB::table('attendances')->insert([
                'employee_id' => $data['employee_id'],
                'attendance_date' => $data['attendance_date'],
                'status' => $data['status'],
                'check_in' => $data['check_in'] ?? null,
                'check_out' => $data['check_out'] ?? null,
                'notes' => $data['notes'] ?? null,
                'recorded_by' => $data['recorded_by'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (QueryException $e) {
            // MySQL error 1062 = duplicate unique key.
            if (($e->errorInfo[1] ?? null) === 1062) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'employee_id' => 'Karyawan tersebut sudah memiliki catatan absensi pada tanggal yang dipilih.',
                    ]);
            }

            throw $e;
        }

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Catatan absensi berhasil ditambahkan.');
    }


    public function edit(Attendance $attendance)
    {
        $employees = Employee::with('department')
            ->orderBy('full_name')
            ->get();

        return view('attendances.edit', compact(
            'attendance',
            'employees'
        ));
    }

    public function update(
        UpdateAttendanceRequest $request,
        Attendance $attendance
    ) {
        $data = $request->validated();

        try {
            $attendance->update($data);
        } catch (QueryException $e) {
            if (($e->errorInfo[1] ?? null) === 1062) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'employee_id' =>
                        'Karyawan sudah memiliki absensi pada tanggal tersebut.',
                    ]);
            }

            throw $e;
        }

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Catatan absensi berhasil diperbarui.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Catatan absensi berhasil dihapus.');
    }

    public function myIndex(Request $request)
    {
        $user = $request->user();

        abort_unless($user->role === 'employee', 403);

        abort_unless($user->employee_id, 403, 'Akun belum terhubung dengan data karyawan.');

        $attendances = Attendance::where('employee_id', $user->employee_id)
            ->when($request->filled('date_from'), function ($query) use ($request) {
                $query->whereDate('attendance_date', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($query) use ($request) {
                $query->whereDate('attendance_date', '<=', $request->date_to);
            })
            ->orderByDesc('attendance_date')
            ->paginate(10)
            ->withQueryString();

        return view('attendances.mine', compact('attendances'));
    }
}
