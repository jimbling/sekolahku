<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'students' => 'required|array',
            'students.*.nis' => 'required|string',
            'students.*.name' => 'required|string',
            'students.*.birth_place' => 'required|string',
            'students.*.birth_date' => 'required|date',
            'students.*.gender' => 'required|string|in:L,P',
            'students.*.email' => 'nullable|email',
            'students.*.no_hp' => 'nullable|string',
            'students.*.alamat' => 'nullable|string',
        ];
    }
}
