<?php

// app/Http/Requests/Backend/Video/VideoStoreRequest.php
namespace App\Http\Requests\Backend\Media;

use Illuminate\Foundation\Http\FormRequest;

class VideoStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'post_title' => 'required|max:255',
            'post_content' => 'required',
        ];
    }
}
