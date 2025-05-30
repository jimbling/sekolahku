<?php

namespace App\Http\Requests\Backend\Gtk;

use Illuminate\Foundation\Http\FormRequest;

class StoreGtkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gtk_name' => 'required|string|max:255',
            'gtk_jk' => 'required|in:M,F',
            'gtk_status_induk' => 'required|boolean',
            'gtk_keaktifan' => 'required|string|max:255',
            'gtk_email' => 'required|email|unique:gtks,email',
            'gtk_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'gtk_name.required' => 'Nama GTK harus diisi.',
            'gtk_name.string' => 'Nama GTK harus berupa string.',
            'gtk_name.max' => 'Nama GTK tidak boleh lebih dari :max karakter.',
            'gtk_jk.required' => 'Jenis kelamin harus dipilih.',
            'gtk_jk.in' => 'Jenis kelamin harus salah satu dari M atau F.',
            'gtk_status_induk.required' => 'Status induk harus diisi.',
            'gtk_status_induk.boolean' => 'Status induk harus Ya atau Tidak.',
            'gtk_keaktifan.required' => 'Status GTK harus diisi.',
            'gtk_keaktifan.string' => 'Status GTK harus berupa string.',
            'gtk_keaktifan.max' => 'Status GTK tidak boleh lebih dari :max karakter.',
            'gtk_email.required' => 'Email GTK harus diisi.',
            'gtk_email.email' => 'Format email tidak valid.',
            'gtk_email.unique' => 'Email GTK sudah digunakan.',
            'gtk_foto.image' => 'Foto harus berupa gambar.',
            'gtk_foto.mimes' => 'Gambar harus memiliki ekstensi jpg, jpeg, atau png.',
            'gtk_foto.max' => 'Ukuran gambar tidak boleh lebih dari 500KB.',
        ];
    }
}
