<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\School;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class SchoolRegistrationController extends Controller
{
    public function showForm()
    {
        $school = School::first(); // atau bisa juga where kondisi tertentu

        if ($school && $school->license_status === 'active') {
            return redirect()->route('patch.index')->with('success', 'Sekolah sudah terdaftar.');
        }

        return view('admin.pemeliharaan.register-school', ['judul' => 'Registrasi Sekolah']);
    }


    public function verifyToken(Request $request)
    {
        $payload = $request->json()->all();
        logger('Payload diterima:', $payload);

        if (!isset($payload['token']) || !is_string($payload['token'])) {
            return response()->json(['message' => 'Token wajib diisi.'], 422);
        }

        $tokenValue = $payload['token'];

        $response = Http::asJson()->post('http://adment.test:8001/api/register-client', [
            'token' => $tokenValue,
        ]);

        logger('Respon Server:', [
            'status' => $response->status(),
            'body' => $response->body(),
            'json' => $response->json(),
        ]);

        $responseData = $response->json();

        if ($response->successful() && $responseData['status'] === 'success') {
            return response()->json($responseData['school']);
        }

        // Ambil pesan dari server pusat, default jika tidak ada
        $errorMessage = $responseData['message'] ?? 'Token tidak valid.';

        return response()->json([
            'message' => $errorMessage,
            'server_response' => $responseData,
        ], $response->status()); // gunakan status asli dari server pusat
    }




    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'school_uuid' => 'required|uuid|unique:schools,school_uuid',
            'name' => 'required|string',
            'npsn' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'license_key' => 'required|string',
            'valid_until' => 'nullable|date',
        ]);

        // Simpan data ke database lokal
        $school = School::create([
            ...$request->only([
                'school_uuid',
                'name',
                'npsn',
                'email',
                'address',
                'license_key',
            ]),
            'license_status' => 'active',
            'valid_until' => $request->valid_until,
            'domain' => $request->getHost(), // simpan domain dari request
        ]);

        // Kirim konfirmasi ke server pusat
        Http::post('http://adment.test:8001/api/confirm-token-used', [
            'token' => $school->license_key,
            'domain' => $school->domain,
            'activated_at' => now()->toDateTimeString(), // kirim waktu aktivasi
        ]);

        return redirect()->route('patch.index')->with('success', 'Registrasi berhasil disimpan.');
    }
}
