<?php
// app/Http/Requests/Backend/Tag/TagStoreRequest.php
namespace App\Http\Requests\Backend\Blog\Tag;

use Illuminate\Foundation\Http\FormRequest;

class TagStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tag_name' => 'required|string|max:255|unique:tags,name',
        ];
    }

    public function messages()
    {
        return [
            'tag_name.required' => 'Nama tag harus diisi.',
            'tag_name.unique' => 'Tag dengan nama ini sudah ada.',
        ];
    }
}
