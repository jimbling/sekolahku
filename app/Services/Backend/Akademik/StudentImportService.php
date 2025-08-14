<?php

namespace App\Services\Backend\Akademik;

use App\Models\Student;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class StudentImportService
{
    public function parseRawData(string $rawData): array
    {
        Log::info("📥 Memulai parsing data mentah untuk import siswa");

        $rows = explode("\n", trim($rawData));
        $data = [];

        foreach ($rows as $index => $row) {
            $columns = preg_split("/\t+/", trim($row));

            // Log setiap baris yang diparsing
            Log::debug("🔍 Baris " . ($index + 1) . " diparsing", [
                'columns' => $columns
            ]);

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
            } else {
                Log::warning("⚠️ Baris " . ($index + 1) . " dilewati karena kolom tidak lengkap", [
                    'columns' => $columns
                ]);
            }
        }

        Log::info("✅ Parsing selesai", ['total_rows' => count($data)]);
        return $data;
    }

    public function import(array $students): array
    {
        Log::info("Memulai proses import siswa", ['total_students' => count($students)]);

        $imported = 0;
        $errors = [];

        foreach ($students as $index => $student) {
            try {
                Log::debug("Mengimport siswa", ['row' => $index + 1, 'data' => $student]);

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

                    Log::info("✅ Akun user dibuat untuk siswa", [
                        'row' => $index + 1,
                        'email' => $student['email']
                    ]);
                }

                $imported++;
            } catch (\Throwable $e) {
                $errorMessage = "❌ Baris " . ($index + 1) . " gagal diimport: " . $e->getMessage();

                // Simpan ke array untuk dikirim ke UI
                $errors[] = $errorMessage;

                // Log error lengkap dengan data siswa & trace
                Log::error($errorMessage, [
                    'row' => $index + 1,
                    'student_data' => $student,
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        Log::info("🏁 Proses import selesai", [
            'total_students' => count($students),
            'imported' => $imported,
            'errors_count' => count($errors)
        ]);

        return [
            'success' => $imported > 0,
            'message' => "$imported data berhasil diimport.",
            'imported' => $imported,
            'errors' => $errors,
        ];
    }
}
