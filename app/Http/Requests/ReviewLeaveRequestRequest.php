<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewLeaveRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(
            $this->user()?->role,
            ['hr'],
            true
        );
    }

    public function rules(): array
    {
        return [
            'status' => [
                'required',
                Rule::in(['approved', 'rejected']),
            ],
            'review_note' => [
                'nullable',
                'string',
                'max:1000',
                Rule::requiredIf(
                    $this->input('status') === 'rejected'
                ),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Keputusan wajib dipilih.',
            'status.in' => 'Keputusan tidak valid.',
            'review_note.required' => 'Alasan penolakan wajib diisi.',
        ];
    }
}
