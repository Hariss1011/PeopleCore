<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $positions = Position::with('department')
            ->withCount('employees')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('department', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->when($request->filled('department_id'), function ($query) use ($request) {
                $query->where('department_id', $request->department_id);
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $departments = Department::orderBy('name')->get();

        return view('positions.index', compact('positions', 'departments'));
    }

    public function create()
    {
        $position = new Position();
        $departments = Department::where('is_active', true)->orderBy('name')->get();

        return view('positions.form', compact('position', 'departments'));
    }

    public function store(Request $request)
    {
        Position::create($this->validatePosition($request));

        return redirect()
            ->route('positions.index')
            ->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function edit(Position $position)
    {
        $departments = Department::where('is_active', true)
            ->orWhere('id', $position->department_id)
            ->orderBy('name')
            ->get();

        return view('positions.form', compact('position', 'departments'));
    }

    public function update(Request $request, Position $position)
    {
        $position->update($this->validatePosition($request, $position));

        return redirect()
            ->route('positions.index')
            ->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy(Position $position)
    {
        if ($position->employees()->exists()) {
            return back()->with(
                'error',
                'Jabatan tidak dapat dihapus karena masih digunakan oleh karyawan.'
            );
        }

        $position->delete();

        return redirect()
            ->route('positions.index')
            ->with('success', 'Jabatan berhasil dihapus.');
    }

    private function validatePosition(Request $request, ?Position $position = null): array
    {
        return $request->validate([
            'department_id' => ['required', 'exists:departments,id'],
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('positions', 'name')
                    ->where('department_id', $request->department_id)
                    ->ignore($position?->id),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['required', 'boolean'],
        ]);
    }
}
