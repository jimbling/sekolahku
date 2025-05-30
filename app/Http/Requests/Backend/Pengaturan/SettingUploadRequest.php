<?php
// app/Http/Requests/Backend/Setting/SettingUploadRequest.php
namespace App\Http\Requests\Backend\Pengaturan;

use Illuminate\Foundation\Http\FormRequest;

class SettingUploadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
