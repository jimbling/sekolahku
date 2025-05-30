<?php

// app/Http/Requests/Backend/Media/ImageStoreRequest.php
namespace App\Http\Requests\Backend\Media;

use Illuminate\Foundation\Http\FormRequest;

class ImageStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'caption' => 'nullable|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'files.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
