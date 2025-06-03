<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // pastikan boleh digunakan semua user (login maupun tamu)
    }

    public function rules(): array
    {
        $isGuest = !auth()->check();

        return [
            'post_id' => ['required', 'exists:posts,id'],
            'content' => ['required', 'string', 'max:2000'],
            'parent_id' => ['nullable', 'exists:comments,id'],
            'guest_name' => $isGuest ? ['required', 'string', 'max:100'] : ['nullable'],
            'guest_email' => $isGuest ? ['required', 'email', 'max:150'] : ['nullable'],
        ];
    }


    public function messages(): array
    {
        return [
            'post_id.required' => 'Postingan tidak ditemukan.',
            'content.required' => 'Komentar tidak boleh kosong.',
            'guest_name.required' => 'Nama wajib diisi jika Anda belum login.',
            'guest_email.required' => 'Email wajib diisi jika Anda belum login.',
        ];
    }
}
