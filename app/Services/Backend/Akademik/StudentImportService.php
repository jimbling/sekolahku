<?php

namespace App\Services\Backend\Akademik;

use App\Models\Student;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class StudentImportService
{
    public function parseRawData(string $rawData): array
    {
        $rows = explode("\n", trim($rawData));
        $data = [];

        foreach ($rows as $row) {
            $columns = preg_split("/\t+/", trim($row));
            if (count($columns) >= 8) {
                $data[] = [
                    'nis' => $columns[0],
                    'name' => $columns[1],
                    'birth_place' => $columns[2],
                    'birth_date' => $columns[3],
                    'gender' => $columns[4],
                    'email' => $columns[5],
                    'no_hp' => $columns[6],
                    'alamat' => $columns[7],
                ];
            }
        }

        return $data;
    }

    public function import(array $students): array
    {
        $imported = 0;
        $errors = [];

        foreach ($students as $index => $student) {
            try {
                $studentModel = Student::create([
                    'nis' => $student['nis'],
                    'name' => $student['name'],
                    'birth_place' => $student['birth_place'],
                    'birth_date' => Carbon::parse($student['birth_date']),
                    'gender' => $student['gender'],
                    'email' => $student['email'] ?? null,
                    'no_hp' => $student['no_hp'] ?? null,
                    'alamat' => $student['alamat'] ?? null,
                    'student_status_id' => 1,
                ]);

                // Buat akun user siswa jika email tersedia
                if (!empty($student['email'])) {
                    $studentModel->user()->create([
                        'name' => $studentModel->name,
                        'email' => $studentModel->email,
                        'password' => Hash::make('password123'), // default password
                    ]);
                }

                $imported++;
            } catch (\Throwable $e) {
                $errors[] = "Baris " . ($index + 1) . ": " . $e->getMessage();
            }
        }

        return [
            'success' => true,
            'message' => "$imported data berhasil diimport.",
            'imported' => $imported,
            'errors' => $errors,
        ];
    }
}
