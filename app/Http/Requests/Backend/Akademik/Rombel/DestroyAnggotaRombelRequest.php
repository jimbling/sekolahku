<?php

namespace App\Http\Requests\Backend\Akademik\Rombel;

use Illuminate\Foundation\Http\FormRequest;

class DestroyAnggotaRombelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rombel_id' => 'required|integer',
            'student_ids' => 'required|array',
        ];
    }
}
