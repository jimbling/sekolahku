<?php

// app/Http/Controllers/Backend/AnggotaRombelController.php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Services\Backend\Akademik\AnggotaRombelService;
use App\Http\Requests\Backend\Akademik\Rombel\StoreAnggotaRombelRequest;
use App\Http\Requests\Backend\Akademik\Rombel\DestroyAnggotaRombelRequest;

class AnggotaRombelController extends Controller
{
    protected $anggotaRombelService;

    public function __construct(AnggotaRombelService $anggotaRombelService)
    {
        $this->anggotaRombelService = $anggotaRombelService;
    }

    public function store(StoreAnggotaRombelRequest $request)
    {
        try {
            $this->anggotaRombelService->tambahAnggota(
                $request->rombel_id,
                $request->student_ids
            );

            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan di server.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy(DestroyAnggotaRombelRequest $request)
    {
        $this->anggotaRombelService->hapusAnggota(
            $request->rombel_id,
            $request->student_ids
        );

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    public function deleteSelected(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;

            if (!empty($ids)) {
                $this->anggotaRombelService->hapusBerdasarkanId($ids);

                return response()->json([
                    'type' => 'success',
                    'message' => 'Data berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Tidak ada data yang dipilih untuk dihapus.'
                ], 422);
            }
        }
    }
}
