<?php

namespace App\Http\Requests\Backend\Blog\Post;

use Illuminate\Foundation\Http\FormRequest;

class SambutanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'post_title' => 'required|string|max:255',
            'post_content' => 'required',
        ];
    }
}
