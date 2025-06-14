<?php

namespace App\Http\Requests\Backend\Akademik\PesertaDidik;

use Illuminate\Foundation\Http\FormRequest;

class PreviewImportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'raw_data' => 'required|string',
        ];
    }
}
