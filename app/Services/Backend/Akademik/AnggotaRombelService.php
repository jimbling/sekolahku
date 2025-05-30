<?php

namespace App\Services\Backend\Akademik;

use App\Models\AnggotaRombel;

class AnggotaRombelService
{
    public function tambahAnggota(int $rombelId, array $studentIds): void
    {
        foreach ($studentIds as $studentId) {
            AnggotaRombel::updateOrCreate([
                'rombel_id' => $rombelId,
                'student_id' => $studentId,
            ]);
        }
    }

    public function hapusAnggota(int $rombelId, array $studentIds): void
    {
        AnggotaRombel::where('rombel_id', $rombelId)
            ->whereIn('student_id', $studentIds)
            ->delete();
    }

    public function hapusBerdasarkanId(array $ids): void
    {
        AnggotaRombel::whereIn('id', $ids)->delete();
    }
}
