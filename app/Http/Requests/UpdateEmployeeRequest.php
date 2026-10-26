<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employee = $this->route('employee');

        return [
            'employee_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('employees', 'employee_number')
                    ->ignore($employee->id),
            ],

            'department_id' => [
                'required',
                'integer',
                Rule::exists('departments', 'id')
                    ->where('is_active', true),
            ],

            'position_id' => [
                'required',
                'integer',
                Rule::exists('positions', 'id')
                    ->where(fn($query) => $query
                        ->where('department_id', $this->input('department_id'))
                        ->where('is_active', true)),
            ],

            'full_name' => ['required', 'string', 'max:150'],

            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('employees', 'email')
                    ->ignore($employee->id),
            ],

            'phone' => ['nullable', 'string', 'max:25'],
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'address' => ['nullable', 'string'],

            'hire_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'employment_type' => [
                'required',
                Rule::in(['permanent', 'contract']),
            ],

            'contract_end_date' => [
                'nullable',
                'required_if:employment_type,contract',
                'prohibited_unless:employment_type,contract',
                'date',
                'after:hire_date',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'employee_number.required' => 'Nomor karyawan wajib diisi.',
            'employee_number.unique' => 'Nomor karyawan sudah digunakan.',
            'department_id.exists' => 'Departemen tidak valid atau tidak aktif.',
            'position_id.exists' => 'Jabatan tidak valid atau tidak sesuai departemen.',
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'email.unique' => 'Email sudah digunakan oleh karyawan lain.',
            'hire_date.before_or_equal' => 'Tanggal masuk tidak boleh melebihi hari ini.',
            'contract_end_date.required_if' => 'Tanggal akhir kontrak wajib diisi.',
            'contract_end_date.prohibited_unless' => 'Karyawan permanen tidak boleh memiliki tanggal akhir kontrak.',
            'contract_end_date.after' => 'Tanggal akhir kontrak harus setelah tanggal masuk.',
        ];
    }
}
