<?php
// app/Http/Requests/Backend/Media/SliderUpdateRequest.php
namespace App\Http\Requests\Backend\Media;

use Illuminate\Foundation\Http\FormRequest;

class SliderUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sliders_caption' => 'required|string|max:255',
            'sliders_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'sliders_caption.required' => 'Caption harus diisi',
            'sliders_photo.image' => 'File yang diunggah harus berupa gambar.',
            'sliders_photo.mimes' => 'Gambar harus berupa file jpeg, png, jpg, atau gif.',
            'sliders_photo.max' => 'Ukuran gambar maksimum adalah 2MB.',
        ];
    }
}
