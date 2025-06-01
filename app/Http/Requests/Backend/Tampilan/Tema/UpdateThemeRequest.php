<?php

namespace App\Http\Requests\Backend\Tampilan\Tema;

use Illuminate\Foundation\Http\FormRequest;

class UpdateThemeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $themeId = $this->route('theme')->id;

        return [
            'name'        => 'required|string|max:100',
            'folder_name' => 'required|string|max:100|unique:themes,folder_name,' . $themeId,
            'description' => 'nullable|string',
            'author'      => 'nullable|string|max:100',
            'version'     => 'nullable|string|max:50',
        ];
    }
}
