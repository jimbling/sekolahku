<?php

namespace App\Http\Requests\Backend\Blog\Post;

use Illuminate\Foundation\Http\FormRequest;

class HalamanRequest extends FormRequest
{
    public function authorize()
    {
        return true; // atau sesuaikan dengan policy
    }

    public function rules()
    {
        return [
            'post_title' => 'required|max:255',
            'post_content' => 'required',
            'post_status' => 'required|in:Publish,Draft',
            'post_comment_status' => 'required|in:open,close',
        ];
    }
}
