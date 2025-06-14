<?php

namespace App\Http\Requests\Backend\Akademik\PesertaDidik;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $studentId = $this->route('id');

        return [
            'students_name' => 'required|string|max:255',
            'students_no_induk' => 'required|numeric|unique:students,nis,' . $studentId,
            'students_tempat_lahir' => 'required',
            'students_tanggal_lahir' => 'required|date',
            'students_keaktifan' => 'required',
            'students_email' => 'required|email',
            'students_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:500',
        ];
    }

    public function messages()
    {
        return [
            'students_name.required' => 'Nama siswa harus diisi.',
            'students_no_induk.unique' => 'Nomor Induk Siswa sudah digunakan.',
            'students_name.string' => 'Nama siswa harus berupa teks.',
            'students_name.max' => 'Nama siswa tidak boleh lebih dari :max karakter.',
            'students_no_induk.required' => 'Nomor induk siswa harus diisi.',
            'students_no_induk.numeric' => 'Nomor induk siswa harus berupa angka.',
            'students_tempat_lahir.required' => 'Tempat lahir siswa harus diisi.',
            'students_tanggal_lahir.required' => 'Tanggal lahir siswa harus diisi.',
            'students_tanggal_lahir.date' => 'Tanggal lahir siswa harus berupa tanggal yang valid.',
            'students_keaktifan.required' => 'Status keaktifan siswa harus diisi.',
            'students_email.required' => 'Email siswa harus diisi.',
            'students_email.email' => 'Email siswa harus berupa format email yang valid.',
            'students_foto.image' => 'Foto harus berupa file gambar.',
            'students_foto.mimes' => 'Foto harus memiliki format jpg, jpeg, atau png.',
            'students_foto.max' => 'Ukuran foto tidak boleh lebih dari :max kilobita.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422));
    }
}
