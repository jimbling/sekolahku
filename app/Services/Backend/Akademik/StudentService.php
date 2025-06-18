<?php

// app/Services/StudentService.php
namespace App\Services\Backend\Akademik;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentService
{
    public function getAllActiveStudents()
    {
        return Student::where('student_status_id', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getStudentsForDatatables()
    {
        return Student::select(['id', 'name', 'nis', 'birth_place', 'birth_date', 'gender', 'email', 'student_status_id', 'photo', 'end_date', 'reason'])
            ->where('student_status_id', 1)
            ->orderBy('name', 'asc');
    }

    public function createStudent(array $data)
    {
        $photoPath = null;

        if (isset($data['students_foto']) && $data['students_foto']) {
            $nameSlug = Str::slug($data['students_name']);
            $nis = $data['students_no_induk'] ?? 'no-nis';
            $extension = $data['students_foto']->getClientOriginalExtension();

            $filename = "{$nameSlug}-{$nis}." . $extension;
            $photoPath = $data['students_foto']->storeAs('images/students', $filename, 'public');
        }

        // Simpan siswa
        $student = Student::create([
            'name' => $data['students_name'],
            'nis' => $data['students_no_induk'],
            'birth_place' => $data['students_tempat_lahir'],
            'birth_date' => $data['students_tanggal_lahir'],
            'gender' => $data['students_jk'],
            'email' => $data['students_email'],
            'student_status_id' => $data['students_keaktifan'],
            'photo' => $photoPath,
        ]);

        // Cek jika email tersedia
        if (!empty($data['students_email'])) {
            $student->user()->create([
                'name' => $student->name,
                'email' => $student->email,
                'password' => Hash::make('password123'), // Default password, bisa diganti atau dikirim via email
            ]);
        }

        return $student;
    }

    public function updateStudent($id, array $data)
    {
        $student = Student::findOrFail($id);

        $student->name = $data['students_name'];
        $student->nis = $data['students_no_induk'];
        $student->gender = $data['students_jk'];
        $student->birth_place = $data['students_tempat_lahir'];
        $student->birth_date = $data['students_tanggal_lahir'];
        $student->email = $data['students_email'];
        $student->student_status_id = $data['students_keaktifan'];

        if (isset($data['students_foto']) && $data['students_foto']) {
            // Hapus foto lama jika ada
            if ($student->photo && Storage::disk('public')->exists($student->photo)) {
                Storage::disk('public')->delete($student->photo);
            }

            $nameSlug = Str::slug($student->name);
            $extension = $data['students_foto']->getClientOriginalExtension();
            $filename = $nameSlug . '-' . time() . '.' . $extension;
            $photoPath = $data['students_foto']->storeAs('images/students', $filename, 'public');

            $student->photo = $photoPath;
        }

        $student->save();
        return $student;
    }


    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);

        // Delete photo if exists
        if ($student->photo && Storage::disk('public')->exists($student->photo)) {
            Storage::disk('public')->delete($student->photo);
        }

        return $student->delete();
    }

    public function deleteMultipleStudents(array $ids)
    {
        $students = Student::whereIn('id', $ids)->get();

        // Delete all photos first
        foreach ($students as $student) {
            if ($student->photo && Storage::disk('public')->exists($student->photo)) {
                Storage::disk('public')->delete($student->photo);
            }
        }

        return Student::whereIn('id', $ids)->delete();
    }

    // Alumni/Peserta Didik Tidak Aktif
    public function getAllNonActiveStudents()
    {
        return Student::where('student_status_id', 0)
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getNonActiveStudentsForDatatables()
    {
        return Student::select(['id', 'name', 'nis', 'birth_place', 'birth_date', 'gender', 'email', 'student_status_id', 'photo', 'end_date', 'reason', 'is_alumni'])
            ->where('student_status_id', 0)
            ->orderBy('name', 'asc');
    }

    public function markAsAlumni(array $ids)
    {
        return Student::whereIn('id', $ids)->update([
            'end_date' => now(),
            'is_alumni' => true,
            'reason' => 'Lulus',
            'student_status_id' => 0
        ]);
    }

    public function restoreToActive(array $ids)
    {
        return Student::whereIn('id', $ids)->update([
            'student_status_id' => 1,
            'end_date' => null,
            'is_alumni' => false,
            'reason' => null,
        ]);
    }

    public function createAlumni(array $data)
    {
        $lastStudent = Student::latest('created_at')->first();
        $nextId = 1;

        if ($lastStudent) {
            $lastId = (int) str_replace('alumni_', '', $lastStudent->nis);
            $nextId = $lastId + 1;
        }

        $no_induk = 'alumni_' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        while (Student::where('nis', $no_induk)->exists()) {
            $nextId++;
            $no_induk = 'alumni_' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        }

        $photoPath = null;
        if (isset($data['alumni_foto']) && $data['alumni_foto']) {
            $photoPath = $data['alumni_foto']->store('images/alumni', 'public');
        }

        return Student::create([
            'name' => $data['alumni_nama'],
            'nis' => $no_induk,
            'birth_place' => $data['alumni_tempat_lahir'],
            'birth_date' => $data['alumni_tanggal_lahir'],
            'gender' => $data['alumni_jk'],
            'email' => $data['alumni_email'],
            'alamat' => $data['alumni_alamat'],
            'no_hp' => $data['alumni_phone'],
            'tahun_lulus' => $data['alumni_tahun_lulus'],
            'photo' => $photoPath,
            'end_date' => now(),
            'is_alumni' => true,
            'reason' => 'Lulus',
            'student_status_id' => 0
        ]);
    }
}
