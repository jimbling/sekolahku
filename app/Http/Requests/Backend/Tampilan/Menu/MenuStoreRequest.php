<?php

// app/Http/Requests/Backend/Menu/MenuStoreRequest.php
namespace App\Http\Requests\Backend\Tampilan\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'menus_nama' => 'required|unique:menus,title',
            'menus_tautan' => 'required',
            'menus_target' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'menus_nama.required' => 'Nama Tautan harus diisi.',
            'menus_nama.unique' => 'Nama Tautan sudah ada, silakan masukkan yang lain.',
            'menus_tautan.required' => 'Tautan harus diisi.',
            'menus_target.required' => 'Target harus dipilih.',
        ];
    }
}
