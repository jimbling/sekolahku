<?php
// app/Http/Requests/Backend/Video/VideoUpdateRequest.php
namespace App\Http\Requests\Backend\Media;

use Illuminate\Foundation\Http\FormRequest;

class VideoUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'post_title' => 'required|string|max:255',
            'post_content' => 'nullable|string',
        ];
    }
}
