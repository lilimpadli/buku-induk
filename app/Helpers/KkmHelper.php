<?php

namespace App\Helpers;

use App\Models\Kkm;

class KkmHelper
{
    /**
     * Cek apakah nilai di bawah KKM
     * 
     * @param int $mataPelajaranId
     * @param int $kelasId
     * @param int $tahunAjaranId
     * @param float $nilai
     * @return array ['is_below' => bool, 'kkm' => float, 'message' => string]
     */
    public static function checkKkm($mataPelajaranId, $kelasId, $tahunAjaranId, $nilai)
    {
        // Cari KKM untuk kombinasi ini
        $kkm = Kkm::where('mata_pelajaran_id', $mataPelajaranId)
            ->where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->first();

        // Jika KKM tidak ditemukan, gunakan default 75
        $nilaiKkm = $kkm ? $kkm->nilai_kkm : 75;

        $isBelow = $nilai < $nilaiKkm;

        return [
            'is_below' => $isBelow,
            'kkm' => $nilaiKkm,
            'message' => $isBelow ? "Nilai ($nilai) di bawah KKM ($nilaiKkm)" : null
        ];
    }
}