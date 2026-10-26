<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeaveTypeController extends Controller
{
    public function index(Request $request)
    {
        $leaveTypes = LeaveType::withCount('leaveRequests')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('is_active', $request->status === 'active');
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('leave-types.index', compact('leaveTypes'));
    }

    public function create()
    {
        $leaveType = new LeaveType();

        return view('leave-types.form', compact('leaveType'));
    }

    public function store(Request $request)
    {
        LeaveType::create($this->validateLeaveType($request));

        return redirect()
            ->route('leave-types.index')
            ->with('success', 'Jenis cuti berhasil ditambahkan.');
    }

    public function edit(LeaveType $leaveType)
    {
        return view('leave-types.form', compact('leaveType'));
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $leaveType->update($this->validateLeaveType($request, $leaveType));

        return redirect()
            ->route('leave-types.index')
            ->with('success', 'Jenis cuti berhasil diperbarui.');
    }

    public function destroy(LeaveType $leaveType)
    {
        if ($leaveType->leaveRequests()->exists()) {
            return back()->with(
                'error',
                'Jenis cuti tidak dapat dihapus karena sudah digunakan pada pengajuan cuti.'
            );
        }

        $leaveType->delete();

        return redirect()
            ->route('leave-types.index')
            ->with('success', 'Jenis cuti berhasil dihapus.');
    }

    private function validateLeaveType(Request $request, ?LeaveType $leaveType = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('leave_types', 'name')->ignore($leaveType?->id),
            ],
            'code' => [
                'required',
                'string',
                'max:30',
                Rule::unique('leave_types', 'code')->ignore($leaveType?->id),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['required', 'boolean'],
        ]);
    }
}
