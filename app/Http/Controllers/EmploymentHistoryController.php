<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmploymentHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EmploymentHistoryController extends Controller
{
    public function index(Employee $employee): View
    {
        $employee->load(['department', 'position']);

        $histories = $employee->employmentHistories()
            ->with('changedBy')
            ->paginate(15);

        return view('employment-histories.index', compact(
            'employee',
            'histories'
        ));
    }

    public function create(Employee $employee): View
    {
        $employee->load(['department', 'position']);

        return view('employment-histories.create', compact('employee'));
    }

    public function store(
        Request $request,
        Employee $employee
    ): RedirectResponse {
        $validated = $request->validate([
            'employment_status' => [
                'required',
                'string',
                Rule::in([
                    'active',
                    'inactive',
                    'resigned',
                    'terminated',
                ]),
            ],
            'effective_date' => [
                'required',
                'date',
            ],
            'reason' => [
                'required',
                'string',
                'max:2000',
            ],
        ], [
            'employment_status.required' => 'Status karyawan wajib dipilih.',
            'employment_status.in' => 'Status karyawan tidak valid.',
            'effective_date.required' => 'Tanggal efektif wajib diisi.',
            'effective_date.date' => 'Tanggal efektif tidak valid.',
            'reason.required' => 'Alasan perubahan wajib diisi.',
            'reason.max' => 'Alasan perubahan maksimal 2.000 karakter.',
        ]);

        $result = DB::transaction(function () use (
            $employee,
            $validated,
            $request
        ) {
            $lockedEmployee = Employee::query()
                ->lockForUpdate()
                ->findOrFail($employee->id);

            $oldStatus = $lockedEmployee->employment_status;
            $newStatus = $validated['employment_status'];

            if ($oldStatus === $newStatus) {
                return false;
            }

            $lockedEmployee->update([
                'employment_status' => $newStatus,
            ]);

            EmploymentHistory::create([
                'employee_id' => $lockedEmployee->id,
                'change_type' => 'employment_status',
                'old_value' => $oldStatus,
                'new_value' => $newStatus,
                'effective_date' => $validated['effective_date'],
                'reason' => $validated['reason'],
                'changed_by' => $request->user()->id,
            ]);

            return true;
        });

        if (! $result) {
            return back()
                ->withInput()
                ->withErrors([
                    'employment_status' =>
                    'Status baru sama dengan status karyawan saat ini.',
                ]);
        }

        return redirect()
            ->route('employees.employment-history.index', $employee)
            ->with(
                'success',
                'Status karyawan berhasil diperbarui dan riwayatnya dicatat.'
            );
    }
}
