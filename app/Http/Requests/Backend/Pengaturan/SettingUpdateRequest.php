<?php

// app/Http/Requests/Backend/Setting/SettingUpdateRequest.php
namespace App\Http\Requests\Backend\Pengaturan;

use Illuminate\Foundation\Http\FormRequest;

class SettingUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'setting_value' => 'required',
        ];
    }
}
