<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RaporInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'semester',
        'tahun_ajaran',
        'wali_kelas',
        'nip_wali',
        'kepala_sekolah',
        'nip_kepsek',
        'tanggal_rapor',
    ];

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }
}
