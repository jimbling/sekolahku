<?php
// app/Http/Requests/Backend/Menu/MenuCheckboxStoreRequest.php
namespace App\Http\Requests\Backend\Tampilan\Menu;

use Illuminate\Foundation\Http\FormRequest;

class MenuCheckboxStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'posts' => 'required|array',
            'posts.*' => 'exists:posts,id',
            'menus_target' => 'required',
        ];
    }
}
