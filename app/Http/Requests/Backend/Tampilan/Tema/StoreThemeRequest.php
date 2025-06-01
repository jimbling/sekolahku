<?php

namespace App\Http\Requests\Backend\Tampilan\Tema;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreThemeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'theme_name' => [
                'required',
                'string',
                'alpha_dash',
                Rule::unique('themes', 'theme_name'),
            ],
            'display_name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'theme_file' => 'required|file|mimes:zip|max:20480',
        ];
    }
}
