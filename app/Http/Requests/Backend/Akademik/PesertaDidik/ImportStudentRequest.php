<?php

namespace App\Http\Requests\Backend\Akademik\PesertaDidik;

use Log;
use Illuminate\Foundation\Http\FormRequest;

class ImportStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // set true kalau semua user boleh import
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

    public function messages(): array
    {
        return [
            'students.required' => 'Data siswa wajib diisi.',
            'students.array' => 'Format data siswa tidak valid.',
            'students.*.nis.required' => 'NIS wajib diisi.',
            'students.*.name.required' => 'Nama siswa wajib diisi.',
            'students.*.birth_place.required' => 'Tempat lahir wajib diisi.',
            'students.*.birth_date.required' => 'Tanggal lahir wajib diisi.',
            'students.*.birth_date.date' => 'Tanggal lahir harus format tanggal.',
            'students.*.gender.required' => 'Jenis kelamin wajib diisi.',
            'students.*.gender.in' => 'Jenis kelamin harus L atau P.',
            'students.*.email.email' => 'Format email tidak valid.',
        ];
    }
}
