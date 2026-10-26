<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('employee.department')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('role'), function ($query) use ($request) {
                $query->where('role', $request->role);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $user = new User();

        $employees = Employee::with(['department', 'user'])
            ->orderBy('full_name')
            ->get();

        return view('users.form', compact('user', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateAccount($request);

        if ($validated['role'] !== 'admin' && empty($validated['employee_id'])) {
            return back()
                ->withErrors(['employee_id' => 'Akun HR dan Employee wajib dihubungkan dengan karyawan.'])
                ->withInput();
        }

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Akun berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $employees = Employee::with(['department', 'user'])
            ->orderBy('full_name')
            ->get();

        return view('users.form', compact('user', 'employees'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $this->validateAccount($request, $user);

        if ($validated['role'] !== 'admin' && empty($validated['employee_id'])) {
            return back()
                ->withErrors(['employee_id' => 'Akun HR dan Employee wajib dihubungkan dengan karyawan.'])
                ->withInput();
        }

        // Jangan biarkan Admin menghapus role Admin terakhir miliknya sendiri.
        if (
            $user->id === auth()->id()
            && $user->role === 'admin'
            && $validated['role'] !== 'admin'
            && User::where('role', 'admin')->count() <= 1
        ) {
            return back()
                ->withErrors(['role' => 'Role Admin terakhir tidak dapat dihapus.'])
                ->withInput();
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Akun Admin terakhir tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Akun berhasil dihapus.');
    }

    private function validateAccount(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'role' => ['required', Rule::in(['admin', 'hr', 'employee'])],
            'employee_id' => [
                'nullable',
                'integer',
                'exists:employees,id',
                Rule::unique('users', 'employee_id')->ignore($user?->id),
            ],
            'password' => [
                $user ? 'nullable' : 'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);
    }
}
