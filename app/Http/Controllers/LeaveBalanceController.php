<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Services\LeaveBalanceService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeaveBalanceController extends Controller
{
    public function __construct(
        private readonly LeaveBalanceService $balanceService
    ) {}

    /**
     * Daftar kuota dan saldo cuti untuk Admin/HR.
     */
    public function index(Request $request)
    {
        abort_unless(
            in_array($request->user()->role, ['admin', 'hr'], true),
            403
        );

        $validated = $request->validate([
            'year' => 'nullable|integer|min:2000|max:2100',
            'search' => 'nullable|string|max:100',
            'leave_type_id' => 'nullable|integer|exists:leave_types,id',
        ]);

        $year = (int) ($validated['year'] ?? now()->year);

        $query = LeaveBalance::with([
            'employee.department',
            'leaveType',
        ])->where('year', $year);

        if (! empty($validated['leave_type_id'])) {
            $query->where('leave_type_id', $validated['leave_type_id']);
        }

        if (! empty($validated['search'])) {
            $search = $validated['search'];

            $query->whereHas('employee', function ($employeeQuery) use ($search) {
                $employeeQuery->where(function ($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%")
                        ->orWhere('employee_number', 'like', "%{$search}%");
                });
            });
        }

        $balances = $query
            ->orderBy('employee_id')
            ->orderBy('leave_type_id')
            ->paginate(15)
            ->withQueryString();

        $balances->getCollection()->transform(function ($balance) {
            $balance->used_days = $this->balanceService->usedDays(
                $balance->employee_id,
                $balance->leave_type_id,
                $balance->year
            );

            $balance->remaining_days = max(
                0,
                $balance->quota_days - $balance->used_days
            );

            return $balance;
        });

        $leaveTypes = LeaveType::orderBy('name')->get();

        return view('leave-balances.index', compact(
            'balances',
            'leaveTypes',
            'year'
        ));
    }

    /**
     * Formulir pembuatan kuota.
     */
    public function create(Request $request)
    {
        abort_unless(
            in_array($request->user()->role, ['admin', 'hr'], true),
            403
        );

        $employees = Employee::orderBy('full_name')->get();
        $leaveTypes = LeaveType::where('is_active', true)
            ->orderBy('name')
            ->get();

        $year = (int) request('year', now()->year);

        return view('leave-balances.create', compact(
            'employees',
            'leaveTypes',
            'year'
        ));
    }

    /**
     * Simpan kuota cuti.
     */
    public function store(Request $request)
    {
        abort_unless(
            in_array($request->user()->role, ['admin', 'hr'], true),
            403
        );

        $data = $request->validate([
            'employee_id' => [
                'required',
                'integer',
                'exists:employees,id',
            ],
            'leave_type_id' => [
                'required',
                'integer',
                'exists:leave_types,id',
            ],
            'year' => 'required|integer|min:2000|max:2100',
            'quota_days' => 'required|integer|min:0|max:366',
        ]);

        $exists = LeaveBalance::where('employee_id', $data['employee_id'])
            ->where('leave_type_id', $data['leave_type_id'])
            ->where('year', $data['year'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'employee_id' => 'Kuota untuk karyawan, jenis cuti, dan tahun tersebut sudah tersedia. Silakan edit kuota yang ada.',
                ]);
        }

        LeaveBalance::create($data);

        return redirect()
            ->route('leave-balances.index', ['year' => $data['year']])
            ->with('success', 'Kuota cuti berhasil ditambahkan.');
    }

    /**
     * Formulir edit kuota.
     */
    public function edit(Request $request, LeaveBalance $leaveBalance)
    {
        abort_unless(
            in_array($request->user()->role, ['admin', 'hr'], true),
            403
        );

        $leaveBalance->load(['employee', 'leaveType']);

        $employees = Employee::orderBy('full_name')->get();
        $leaveTypes = LeaveType::orderBy('name')->get();

        return view('leave-balances.edit', compact(
            'leaveBalance',
            'employees',
            'leaveTypes'
        ));
    }

    /**
     * Perbarui kuota.
     */
    public function update(
        Request $request,
        LeaveBalance $leaveBalance
    ) {
        abort_unless(
            in_array($request->user()->role, ['admin', 'hr'], true),
            403
        );

        $data = $request->validate([
            'employee_id' => 'required|integer|exists:employees,id',
            'leave_type_id' => 'required|integer|exists:leave_types,id',
            'year' => 'required|integer|min:2000|max:2100',
            'quota_days' => 'required|integer|min:0|max:366',
        ]);

        $duplicate = LeaveBalance::where('employee_id', $data['employee_id'])
            ->where('leave_type_id', $data['leave_type_id'])
            ->where('year', $data['year'])
            ->where('id', '!=', $leaveBalance->id)
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'employee_id' => 'Kuota untuk karyawan, jenis cuti, dan tahun tersebut sudah tersedia.',
                ]);
        }

        $currentUsedDays = $this->balanceService->usedDays(
            $leaveBalance->employee_id,
            $leaveBalance->leave_type_id,
            $leaveBalance->year
        );

        $identityChanged =
            (int) $data['employee_id'] !== (int) $leaveBalance->employee_id
            || (int) $data['leave_type_id'] !== (int) $leaveBalance->leave_type_id
            || (int) $data['year'] !== (int) $leaveBalance->year;

        if ($currentUsedDays > 0 && $identityChanged) {
            return back()
                ->withInput()
                ->withErrors([
                    'employee_id' => 'Karyawan, jenis cuti, atau tahun tidak dapat diubah karena kuota ini sudah memiliki pemakaian. Buat pengaturan kuota terpisah jika diperlukan.',
                ]);
        }

        $usedDays = $this->balanceService->usedDays(
            $data['employee_id'],
            $data['leave_type_id'],
            (int) $data['year']
        );

        if ((int) $data['quota_days'] < $usedDays) {
            return back()
                ->withInput()
                ->withErrors([
                    'quota_days' => "Kuota tidak boleh lebih kecil daripada cuti yang sudah digunakan ({$usedDays} hari).",
                ]);
        }

        $leaveBalance->update($data);

        return redirect()
            ->route('leave-balances.index', ['year' => $data['year']])
            ->with('success', 'Kuota cuti berhasil diperbarui.');
    }

    /**
     * Hapus pengaturan kuota.
     * Kuota tidak boleh dihapus jika sudah ada pemakaian cuti.
     */
    public function destroy(
        Request $request,
        LeaveBalance $leaveBalance
    ) {
        abort_unless(
            in_array($request->user()->role, ['admin', 'hr'], true),
            403
        );

        $usedDays = $this->balanceService->usedDays(
            $leaveBalance->employee_id,
            $leaveBalance->leave_type_id,
            $leaveBalance->year
        );

        if ($usedDays > 0) {
            return back()->with(
                'error',
                'Kuota tidak dapat dihapus karena sudah digunakan oleh pengajuan cuti yang disetujui.'
            );
        }

        $year = $leaveBalance->year;
        $leaveBalance->delete();

        return redirect()
            ->route('leave-balances.index', ['year' => $year])
            ->with('success', 'Kuota cuti berhasil dihapus.');
    }

    /**
     * Saldo cuti milik Employee yang sedang login.
     */
    public function mine(Request $request)
    {
        abort_unless($request->user()->role === 'employee', 403);

        $employeeId = $request->user()->employee_id;

        abort_unless(
            $employeeId,
            403,
            'Akun belum terhubung dengan data karyawan.'
        );

        $validated = $request->validate([
            'year' => 'nullable|integer|min:2000|max:2100',
        ]);

        $year = (int) ($validated['year'] ?? now()->year);

        $balances = LeaveBalance::with('leaveType')
            ->where('employee_id', $employeeId)
            ->where('year', $year)
            ->orderBy('leave_type_id')
            ->get();

        $balances->transform(function ($balance) {
            $balance->used_days = $this->balanceService->usedDays(
                $balance->employee_id,
                $balance->leave_type_id,
                $balance->year
            );

            $balance->remaining_days = max(
                0,
                $balance->quota_days - $balance->used_days
            );

            return $balance;
        });

        return view('leave-balances.mine', compact(
            'balances',
            'year'
        ));
    }
}
