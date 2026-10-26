<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewLeaveRequestRequest;
use App\Http\Requests\StoreLeaveRequestRequest;
use App\Models\LeaveRequest;
use App\Models\LeaveRequestHistory;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Services\LeaveBalanceService;

class LeaveRequestController extends Controller
{
    /**
     * Daftar pengajuan milik Employee yang sedang login.
     */
    public function myIndex(Request $request)
    {
        abort_unless($request->user()->role === 'employee', 403);

        $employeeId = $request->user()->employee_id;

        abort_unless($employeeId, 403, 'Akun belum terhubung dengan data karyawan.');

        $query = LeaveRequest::with(['leaveType', 'reviewer'])
            ->where('employee_id', $employeeId);

        if ($request->filled('status')) {
            $request->validate([
                'status' => 'in:pending,approved,rejected',
            ]);

            $query->where('status', $request->status);
        }

        $leaveRequests = $query
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('leave-requests.mine', compact('leaveRequests'));
    }

    /**
     * Formulir pengajuan cuti.
     */
    public function create(Request $request)
    {
        abort_unless($request->user()->role === 'employee', 403);

        abort_unless(
            $request->user()->employee_id,
            403,
            'Akun belum terhubung dengan data karyawan.'
        );

        $leaveTypes = LeaveType::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('leave-requests.create', compact('leaveTypes'));
    }

    /**
     * Menyimpan pengajuan baru.
     */
    public function store(
        StoreLeaveRequestRequest $request,
        LeaveBalanceService $balanceService
    ) {
        $data = $request->validated();
        $employeeId = $request->user()->employee_id;

        $leaveType = LeaveType::whereKey($data['leave_type_id'])
            ->where('is_active', true)
            ->first();

        if (! $leaveType) {
            throw ValidationException::withMessages([
                'leave_type_id' => 'Jenis cuti tidak aktif atau tidak ditemukan.',
            ]);
        }

        $leaveRequest = DB::transaction(function () use (
            $data,
            $employeeId,
            $request,
            $balanceService,
        ) {
            // Cegah pengajuan yang tanggalnya bentrok dengan
            // pengajuan pending atau approved milik karyawan.
            $hasConflict = LeaveRequest::where('employee_id', $employeeId)
                ->whereIn('status', ['pending', 'approved'])
                ->whereDate('start_date', '<=', $data['end_date'])
                ->whereDate('end_date', '>=', $data['start_date'])
                ->lockForUpdate()
                ->exists();

            if ($hasConflict) {
                throw ValidationException::withMessages([
                    'start_date' => 'Tanggal cuti berbenturan dengan pengajuan cuti lain yang masih menunggu atau sudah disetujui.',
                ]);
            }

            if ($balanceService->exceedsQuota(
                $employeeId,
                (int) $data['leave_type_id'],
                $data['start_date'],
                $data['end_date']
            )) {
                throw ValidationException::withMessages([
                    'start_date' => 'Pengajuan melebihi sisa kuota cuti pada salah satu tahun yang diajukan, atau kuota cuti belum diatur oleh HR.',
                ]);
            }

            $leaveRequest = LeaveRequest::create([
                'employee_id' => $employeeId,
                'leave_type_id' => $data['leave_type_id'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'reason' => $data['reason'],
                'status' => 'pending',
            ]);

            LeaveRequestHistory::create([
                'leave_request_id' => $leaveRequest->id,
                'changed_by' => $request->user()->id,
                'old_status' => null,
                'new_status' => 'pending',
                'note' => 'Pengajuan cuti dibuat.',
                'changed_at' => now(),
            ]);

            return $leaveRequest;
        });

        return redirect()
            ->route('my.leave-requests.show', $leaveRequest)
            ->with('success', 'Pengajuan cuti berhasil dikirim.');
    }

    /**
     * Detail pengajuan milik Employee.
     */
    public function myShow(Request $request, LeaveRequest $leaveRequest)
    {
        abort_unless($request->user()->role === 'employee', 403);

        abort_unless(
            $request->user()->employee_id
                && $leaveRequest->employee_id === $request->user()->employee_id,
            403
        );

        $leaveRequest->load([
            'leaveType',
            'reviewer',
            'histories.changedBy',
        ]);

        return view('leave-requests.show', compact('leaveRequest'));
    }

    /**
     * Daftar pengajuan untuk ditinjau HR.
     */
    public function approvals(Request $request)
    {
        abort_unless($request->user()->role === 'hr', 403);

        $validated = $request->validate([
            'status' => 'nullable|in:pending,approved,rejected',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'search' => 'nullable|string|max:100',
        ]);

        $query = LeaveRequest::with([
            'employee.department',
            'leaveType',
            'reviewer',
        ]);

        if (! empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (! empty($validated['date_from'])) {
            $query->whereDate('start_date', '>=', $validated['date_from']);
        }

        if (! empty($validated['date_to'])) {
            $query->whereDate('start_date', '<=', $validated['date_to']);
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

        $summary = [
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'approved' => (clone $query)->where('status', 'approved')->count(),
            'rejected' => (clone $query)->where('status', 'rejected')->count(),
        ];

        $leaveRequests = $query
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('leave-requests.approvals', compact(
            'leaveRequests',
            'summary'
        ));
    }

    /**
     * Detail pengajuan untuk HR.
     */
    public function approvalShow(Request $request, LeaveRequest $leaveRequest)
    {
        abort_unless($request->user()->role === 'hr', 403);

        $leaveRequest->load([
            'employee.department',
            'employee.position',
            'leaveType',
            'reviewer',
            'histories.changedBy',
        ]);

        return view('leave-requests.approval-show', compact('leaveRequest'));
    }

    /**
     * HR menyetujui atau menolak pengajuan.
     */
    public function review(
        ReviewLeaveRequestRequest $request,
        LeaveRequest $leaveRequest,
        LeaveBalanceService $balanceService
    ) {
        $data = $request->validated();

        DB::transaction(function () use (
            $request,
            $leaveRequest,
            $data,
            $balanceService,
        ) {
            $lockedRequest = LeaveRequest::whereKey($leaveRequest->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedRequest->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' => 'Pengajuan ini sudah diproses dan tidak dapat diproses ulang.',
                ]);
            }

            // Pastikan pengajuan yang disetujui tidak bertabrakan
            // dengan cuti lain yang sudah disetujui.
            if ($data['status'] === 'approved') {
                $hasApprovedConflict = LeaveRequest::where(
                    'employee_id',
                    $lockedRequest->employee_id
                )
                    ->where('id', '!=', $lockedRequest->id)
                    ->where('status', 'approved')
                    ->whereDate('start_date', '<=', $lockedRequest->end_date)
                    ->whereDate('end_date', '>=', $lockedRequest->start_date)
                    ->exists();

                if ($hasApprovedConflict) {
                    throw ValidationException::withMessages([
                        'status' => 'Pengajuan tidak dapat disetujui karena tanggalnya berbenturan dengan cuti lain yang sudah disetujui.',
                    ]);
                }

                if ($balanceService->exceedsQuota(
                    $lockedRequest->employee_id,
                    $lockedRequest->leave_type_id,
                    $lockedRequest->start_date,
                    $lockedRequest->end_date,
                    $lockedRequest->id
                )) {
                    throw ValidationException::withMessages([
                        'status' => 'Pengajuan tidak dapat disetujui karena kuota cuti tidak mencukupi. Periksa kuota karyawan untuk setiap tahun yang terkait.',
                    ]);
                }
            }

            $oldStatus = $lockedRequest->status;

            $lockedRequest->update([
                'status' => $data['status'],
                'reviewed_by' => $request->user()->id,
                'reviewed_at' => now(),
                'review_note' => $data['review_note'] ?? null,
            ]);

            LeaveRequestHistory::create([
                'leave_request_id' => $lockedRequest->id,
                'changed_by' => $request->user()->id,
                'old_status' => $oldStatus,
                'new_status' => $data['status'],
                'note' => $data['review_note'] ?? (
                    $data['status'] === 'approved'
                    ? 'Pengajuan cuti disetujui.'
                    : null
                ),
                'changed_at' => now(),
            ]);
        });

        return redirect()
            ->route('leave-approvals.show', $leaveRequest)
            ->with(
                'success',
                $data['status'] === 'approved'
                    ? 'Pengajuan cuti berhasil disetujui.'
                    : 'Pengajuan cuti berhasil ditolak.'
            );
    }
}
