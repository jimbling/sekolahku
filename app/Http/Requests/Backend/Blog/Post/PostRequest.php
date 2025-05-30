<?php
// app/Http/Requests/PostRequest.php
namespace App\Http\Requests\Backend\Blog\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'post_status' => 'required|in:Publish,Draft',
            'post_comment_status' => 'required|in:open,close',
            'post_image' => 'image|mimes:jpeg,png,jpg,gif|max:5048',
            'post_categories' => 'required|array|min:1',
            'post_tags' => 'nullable|array',
        ];
    }

    public function messages()
    {
        return [
            'post_title.required' => 'Judul postingan harus diisi.',
            'post_title.max' => 'Judul postingan tidak boleh lebih dari 255 karakter.',
            'post_content.required' => 'Konten postingan harus diisi.',
            'post_status.required' => 'Status postingan harus dipilih.',
            'post_status.in' => 'Status postingan harus salah satu dari Publish atau Draft.',
            'post_comment_status.required' => 'Status komentar postingan harus dipilih.',
            'post_comment_status.in' => 'Status komentar postingan harus salah satu dari open atau close.',
            'post_image.image' => 'File yang diunggah harus berupa gambar.',
            'post_image.mimes' => 'Gambar harus memiliki ekstensi: jpeg, png, jpg, atau gif.',
            'post_image.max' => 'Ukuran gambar tidak boleh lebih dari 5 MB.',
            'post_categories.required' => 'Kategori postingan harus dipilih.',
            'post_categories.array' => 'Kategori postingan harus berupa array.',
            'post_categories.min' => 'Setidaknya satu kategori harus dipilih.',
            'post_tags.array' => 'Tags harus berupa array.',
        ];
    }
}
