<?php

// app/Http/Requests/Backend/Link/LinkStoreRequest.php
namespace App\Http\Requests\Backend\Blog;

use Illuminate\Foundation\Http\FormRequest;

class LinkStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tautan_name' => 'required|string|max:255',
            'tautan_url' => 'required|string|max:255',
            'tautan_target' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'tautan_name.required' => 'Nama tautan harus diisi',
            'tautan_url.required' => 'Url tautan harus diisi.',
        ];
    }
}
