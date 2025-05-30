<?php

namespace App\Http\Requests\Backend\Akademik\Rombel;

use Illuminate\Foundation\Http\FormRequest;

class StoreRombelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Sesuaikan jika ada kebijakan khusus
    }

    public function rules(): array
    {
        return [
            'tahun_ajaran' => 'required|exists:academic_years,id',
            'kelas' => 'required|exists:classrooms,id',
            'wali_kelas' => 'required|exists:gtks,id',
        ];
    }

    public function messages(): array
    {
        return [
            'tahun_ajaran.required' => 'Tahun Ajaran harus diisi.',
            'tahun_ajaran.exists' => 'Tahun Ajaran yang dipilih tidak valid.',
            'kelas.required' => 'Kelas harus diisi.',
            'kelas.exists' => 'Kelas yang dipilih tidak valid.',
            'wali_kelas.required' => 'Wali Kelas harus diisi.',
            'wali_kelas.exists' => 'Wali Kelas yang dipilih tidak valid.',
        ];
    }
}
