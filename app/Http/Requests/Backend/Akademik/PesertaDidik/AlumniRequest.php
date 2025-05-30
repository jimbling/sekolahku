<?php

// app/Http/Requests/AlumniRequest.php
namespace App\Http\Requests\Backend\Akademik\PesertaDidik;

use Illuminate\Foundation\Http\FormRequest;

class AlumniRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'alumni_nama' => 'required|string|max:255',
            'alumni_tempat_lahir' => 'required|string|max:255',
            'alumni_tanggal_lahir' => 'required|date',
            'alumni_email' => 'required|email',
            'alumni_tahun_lulus' => 'required|numeric',
            'alumni_phone' => 'required|numeric',
            'alumni_jk' => 'required|string|in:M,F',
            'alumni_alamat' => 'required|string|max:500',
            'alumni_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:500',
        ];
    }

    public function messages()
    {
        return [
            'alumni_nama.required' => 'Nama alumni harus diisi.',
            'alumni_nama.string' => 'Nama alumni harus berupa teks.',
            'alumni_nama.max' => 'Nama alumni tidak boleh lebih dari :max karakter.',
            'alumni_tempat_lahir.required' => 'Tempat lahir alumni harus diisi.',
            'alumni_tempat_lahir.string' => 'Tempat lahir alumni harus berupa teks.',
            'alumni_tempat_lahir.max' => 'Tempat lahir alumni tidak boleh lebih dari :max karakter.',
            'alumni_tanggal_lahir.required' => 'Tanggal lahir alumni harus diisi.',
            'alumni_tanggal_lahir.date' => 'Tanggal lahir alumni harus berupa tanggal yang valid.',
            'alumni_email.required' => 'Email alumni harus diisi.',
            'alumni_email.email' => 'Email alumni harus berupa format email yang valid.',
            'alumni_tahun_lulus.required' => 'Tahun Lulus alumni harus diisi.',
            'alumni_tahun_lulus.numeric' => 'Tahun Lulus alumni harus berupa angka.',
            'alumni_phone.required' => 'No HP alumni harus diisi.',
            'alumni_phone.numeric' => 'No HP alumni harus berupa angka.',
            'alumni_jk.required' => 'Jenis kelamin harus diisi.',
            'alumni_jk.string' => 'Jenis kelamin harus berupa teks.',
            'alumni_jk.in' => 'Jenis kelamin harus salah satu dari M atau F.',
            'alumni_alamat.required' => 'Alamat alumni harus diisi.',
            'alumni_alamat.string' => 'Alamat alumni harus berupa teks.',
            'alumni_alamat.max' => 'Alamat alumni tidak boleh lebih dari :max karakter.',
            'alumni_foto.image' => 'Foto harus berupa file gambar.',
            'alumni_foto.mimes' => 'Foto harus memiliki format jpg, jpeg, atau png.',
            'alumni_foto.max' => 'Ukuran foto tidak boleh lebih dari :max kilobyte.',
        ];
    }
}
