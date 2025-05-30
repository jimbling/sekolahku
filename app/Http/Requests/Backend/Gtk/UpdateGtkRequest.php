<?php

namespace App\Http\Requests\Backend\Gtk;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGtkRequest extends FormRequest
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
            'gtk_email' => 'required|email|unique:gtks,email,' . $this->route('id'),
            'gtk_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'gtk_name.required' => 'Nama GTK harus diisi.',
            // tambahkan pesan lainnya sesuai kebutuhan
        ];
    }
}
