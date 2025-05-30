<?php
// app/Http/Requests/Backend/Media/AlbumStoreRequest.php
namespace App\Http\Requests\Backend\Media;

use Illuminate\Foundation\Http\FormRequest;

class AlbumStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'photos_album' => 'required',
            'photos_keterangan' => 'required',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'photos_album.required' => 'Nama album harus diisi.',
            'photos_keterangan.required' => 'Keterangan album harus diisi.',
            'cover_photo.image' => 'File sampul harus berupa gambar.',
            'cover_photo.mimes' => 'Format gambar yang diterima adalah jpeg, png, atau jpg.',
            'cover_photo.max' => 'Ukuran gambar maksimum adalah 2MB.',
        ];
    }
}
