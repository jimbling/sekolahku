<?php
// app/Http/Requests/Backend/Tag/TagUpdateRequest.php
namespace App\Http\Requests\Backend\Blog\Tag;

use Illuminate\Foundation\Http\FormRequest;

class TagUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255|unique:tags,name,' . $this->route('tag'),
        ];
    }
}
