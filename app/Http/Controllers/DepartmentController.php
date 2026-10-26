<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::withCount(['employees', 'positions'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        $department = new Department();

        return view('departments.form', compact('department'));
    }

    public function store(Request $request)
    {
        Department::create($this->validateDepartment($request));

        return redirect()
            ->route('departments.index')
            ->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function edit(Department $department)
    {
        return view('departments.form', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $department->update($this->validateDepartment($request, $department));

        return redirect()
            ->route('departments.index')
            ->with('success', 'Departemen berhasil diperbarui.');
    }

    public function destroy(Department $department)
    {
        if ($department->employees()->exists() || $department->positions()->exists()) {
            return back()->with(
                'error',
                'Departemen tidak dapat dihapus karena masih memiliki karyawan atau jabatan.'
            );
        }

        $department->delete();

        return redirect()
            ->route('departments.index')
            ->with('success', 'Departemen berhasil dihapus.');
    }

    private function validateDepartment(Request $request, ?Department $department = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('departments', 'name')->ignore($department?->id),
            ],
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('departments', 'code')->ignore($department?->id),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['required', 'boolean'],
        ]);
    }
}
