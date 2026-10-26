<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmploymentHistory;
use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Employee::query()
            ->with(['department', 'position', 'user']);

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($builder) use ($search) {
                $builder->where('full_name', 'like', "%{$search}%")
                    ->orWhere('employee_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->input('department_id'));
        }

        if ($request->filled('position_id')) {
            $query->where('position_id', $request->input('position_id'));
        }

        if ($request->filled('employment_status')) {
            $query->where(
                'employment_status',
                $request->input('employment_status')
            );
        }

        if ($request->filled('employment_type')) {
            $query->where(
                'employment_type',
                $request->input('employment_type')
            );
        }

        $employees = $query
            ->orderBy('full_name')
            ->paginate(10)
            ->withQueryString();

        $departments = Department::where('is_active', true)
            ->orderBy('name')
            ->get();

        $positions = Position::where('is_active', true)
            ->orderBy('name')
            ->get();

        $totalEmployees = Employee::count();

        $activeEmployees = Employee::where(
            'employment_status',
            'active'
        )->count();

        $contractEmployees = Employee::where(
            'employment_type',
            'contract'
        )->where('employment_status', 'active')->count();

        return view('employees.index', compact(
            'employees',
            'departments',
            'positions',
            'totalEmployees',
            'activeEmployees',
            'contractEmployees'
        ));
    }

    public function create(): View
    {
        $departments = Department::where('is_active', true)
            ->orderBy('name')
            ->get();

        $positions = Position::where('is_active', true)
            ->orderBy('name')
            ->get();

        $employee = new Employee();

        return view('employees.form', [
            'employee' => $employee,
            'departments' => $departments,
            'positions' => $positions,
            'isEdit' => false,
        ]);
    }

    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Status awal ditetapkan oleh sistem, bukan dari input pengguna.
        $data['employment_status'] = 'active';

        $employee = Employee::create($data);

        return redirect()
            ->route('employees.show', $employee)
            ->with('success', 'Data karyawan berhasil ditambahkan dengan status Aktif.');
    }

    public function show(Employee $employee): View
    {
        $employee->load([
            'department',
            'position',
            'user',
        ]);

        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee): View
    {
        $departments = Department::where(function ($query) use ($employee) {
            $query->where('is_active', true)
                ->orWhere('id', $employee->department_id);
        })->orderBy('name')->get();

        $positions = Position::where(function ($query) use ($employee) {
            $query->where('is_active', true)
                ->orWhere('id', $employee->position_id);
        })->orderBy('name')->get();

        return view('employees.form', [
            'employee' => $employee,
            'departments' => $departments,
            'positions' => $positions,
            'isEdit' => true,
        ]);
    }

    public function update(
        UpdateEmployeeRequest $request,
        Employee $employee
    ): RedirectResponse {
        $data = $request->validated();

        // Status kepegawaian sengaja tidak dimasukkan di sini.
        // Perubahan status hanya melalui EmploymentHistoryController.
        $trackedFields = [
            'department_id' => 'department',
            'position_id' => 'position',
            'employment_type' => 'employment_type',
            'hire_date' => 'hire_date',
            'contract_end_date' => 'contract_end_date',
        ];

        DB::transaction(function () use (
            $employee,
            $data,
            $trackedFields,
            $request
        ) {
            $lockedEmployee = Employee::query()
                ->lockForUpdate()
                ->findOrFail($employee->id);

            $oldValues = [];

            foreach ($trackedFields as $field => $changeType) {
                if (!array_key_exists($field, $data)) {
                    continue;
                }

                $oldValue = $lockedEmployee->getAttribute($field);
                $newValue = $data[$field];

                if ($oldValue instanceof \DateTimeInterface) {
                    $oldValue = $oldValue->format('Y-m-d');
                }

                if ($newValue instanceof \DateTimeInterface) {
                    $newValue = $newValue->format('Y-m-d');
                }

                $oldNormalized = $oldValue === null
                    ? null
                    : (string) $oldValue;

                $newNormalized = $newValue === null || $newValue === ''
                    ? null
                    : (string) $newValue;

                if ($oldNormalized !== $newNormalized) {
                    $oldValues[$field] = [
                        'change_type' => $changeType,
                        'old_value' => $oldNormalized,
                        'new_value' => $newNormalized,
                    ];
                }
            }

            // Hanya atribut yang lolos validasi yang diperbarui.
            // employment_status tidak termasuk dalam data tervalidasi.
            $lockedEmployee->update($data);

            foreach ($oldValues as $field => $change) {
                $oldValue = $change['old_value'];
                $newValue = $change['new_value'];

                if ($field === 'department_id') {
                    $oldValue = $oldValue
                        ? Department::find($oldValue)?->name
                        : null;

                    $newValue = $newValue
                        ? Department::find($newValue)?->name
                        : null;
                }

                if ($field === 'position_id') {
                    $oldValue = $oldValue
                        ? Position::find($oldValue)?->name
                        : null;

                    $newValue = $newValue
                        ? Position::find($newValue)?->name
                        : null;
                }

                EmploymentHistory::create([
                    'employee_id' => $lockedEmployee->id,
                    'change_type' => $change['change_type'],
                    'old_value' => $oldValue,
                    'new_value' => $newValue,
                    'effective_date' => now()->toDateString(),
                    'reason' => 'Perubahan melalui formulir edit data karyawan.',
                    'changed_by' => $request->user()->id,
                ]);
            }
        });

        return redirect()
            ->route('employees.show', $employee)
            ->with('success', 'Data karyawan berhasil diperbarui dan perubahan penting dicatat.');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        if ($employee->user()->exists()) {
            return redirect()
                ->route('employees.index')
                ->with(
                    'error',
                    'Karyawan memiliki akun pengguna. Hapus atau alihkan akun melalui prosedur administrasi terlebih dahulu.'
                );
        }

        if (
            $employee->attendances()->exists()
            || $employee->leaveRequests()->exists()
        ) {
            return redirect()
                ->route('employees.index')
                ->with(
                    'error',
                    'Karyawan memiliki riwayat transaksi sehingga tidak dapat dihapus. Ubah statusnya jika karyawan sudah tidak bekerja.'
                );
        }

        if ($employee->employmentHistories()->exists()) {
            return redirect()
                ->route('employees.index')
                ->with(
                    'error',
                    'Karyawan memiliki riwayat kepegawaian sehingga tidak dapat dihapus. Ubah statusnya jika karyawan sudah tidak bekerja.'
                );
        }

        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }
}
