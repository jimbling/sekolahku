<?php

namespace App\Http\Requests\Backend\Akademik\Rombel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;
use DB;

class StoreAnggotaRombelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rombel_id' => 'required|exists:rombongan_belajars,id',
            'student_ids' => 'required|array',
            'student_ids.*' => ['required', 'exists:students,id'],
        ];
    }

    public function withValidator(\Illuminate\Validation\Validator $validator)
    {
        $validator->after(function ($validator) {
            $rombelId = $this->input('rombel_id');
            $studentIds = $this->input('student_ids', []);

            // Ambil semua siswa yang sudah terdaftar di rombel ini
            $existingStudents = DB::table('anggota_rombels')
                ->where('rombel_id', $rombelId)
                ->whereIn('student_id', $studentIds)
                ->pluck('student_id')
                ->toArray();

            if (!empty($existingStudents)) {
                // Ambil nama-nama siswa hanya untuk mereka yang duplikat
                $studentNames = DB::table('students')
                    ->whereIn('id', $existingStudents)
                    ->pluck('name', 'id');

                foreach ($existingStudents as $id) {
                    $name = $studentNames[$id] ?? "ID {$id}";
                    $validator->errors()->add(
                        'student_ids',
                        "Siswa bernama \"{$name}\" sudah terdaftar di rombel ini."
                    );
                }
            }
        });
    }
}
