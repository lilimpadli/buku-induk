<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NomorSurat extends Model
{
    protected $table = 'nomor_surat';

    protected $fillable = [
        'jenis_surat',
        'tahun',
        'nomor_terakhir'
    ];

    public static function getNextNumber($jenisSurat, $tahun = null)
    {
        $tahun = $tahun ?? date('Y');

        $nomorSurat = self::firstOrCreate(
            [
                'jenis_surat' => $jenisSurat,
                'tahun' => $tahun,
            ],
            [
                'nomor_terakhir' => 0
            ]
        );

        $nomorSurat->increment('nomor_terakhir');

        return $nomorSurat->nomor_terakhir;
    }

    public static function resetNumber($jenisSurat, $tahun = null)
    {
        $tahun = $tahun ?? date('Y');
        
        return self::where('jenis_surat', $jenisSurat)
            ->where('tahun', $tahun)
            ->update(['nomor_terakhir' => 0]);
    }
}