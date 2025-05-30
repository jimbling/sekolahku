<?php

// app/Http/Requests/Backend/Link/LinkUpdateRequest.php
namespace App\Http\Requests\Backend\Blog;

use Illuminate\Foundation\Http\FormRequest;

class LinkUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'link_title' => 'required|string|max:255',
            'link_url' => 'required|string|max:255',
            'link_target' => 'required|string|max:255',
        ];
    }
}
