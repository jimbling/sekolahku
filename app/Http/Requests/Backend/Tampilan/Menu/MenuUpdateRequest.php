<?php
// app/Http/Requests/Backend/Menu/MenuUpdateRequest.php
namespace App\Http\Requests\Backend\Tampilan\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'menus_nama' => [
                'required',
                Rule::unique('menus', 'title')->ignore($this->route('id'))
            ],
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
