<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnggotaRombel;

class AnggotaRombelController extends Controller
{
    // Menambahkan siswa ke rombel
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rombel_id' => 'required|exists:rombongan_belajars,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $rombelId = $validated['rombel_id'];
        $studentIds = $validated['student_ids'];

        foreach ($studentIds as $studentId) {
            AnggotaRombel::updateOrCreate(
                ['rombel_id' => $rombelId, 'student_id' => $studentId]
            );
        }

        return response()->json(['success' => true], 200);
    }

    // Menghapus siswa dari rombel
    public function destroy(Request $request)
    {
        // Validasi input
        $request->validate([
            'rombel_id' => 'required|integer',
            'student_ids' => 'required|array'
        ]);

        $rombelId = $request->rombel_id;
        $studentIds = $request->student_ids;

        AnggotaRombel::where('rombel_id', $rombelId)
            ->whereIn('student_id', $studentIds)
            ->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}
