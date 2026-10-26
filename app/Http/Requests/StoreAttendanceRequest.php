<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null
            && in_array($this->user()->role, ['admin', 'hr'], true);
    }

    public function rules(): array
    {
        return [
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'attendance_date' => ['required', 'date', 'before_or_equal:today'],
            'status' => [
                'required',
                'in:present,late,permission,sick,absent',
            ],
            'check_in' => ['nullable', 'date_format:H:i'],
            'check_out' => [
                'nullable',
                'date_format:H:i',
                'after_or_equal:check_in',
            ],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Karyawan wajib dipilih.',
            'employee_id.exists' => 'Karyawan yang dipilih tidak valid.',
            'attendance_date.before_or_equal' => 'Tanggal absensi tidak boleh melewati hari ini.',
            'status.in' => 'Status absensi tidak valid.',
            'check_in.date_format' => 'Format jam masuk tidak valid.',
            'check_out.date_format' => 'Format jam pulang tidak valid.',
            'check_out.after_or_equal' => 'Jam pulang harus sama dengan atau setelah jam masuk.',
        ];
    }
}
