<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NilaiRaport extends Model
{
    use HasFactory;

    protected $table = 'nilai_raports';

    protected $fillable = [
        'siswa_id',
        'mata_pelajaran_id',
        'semester',
        'tahun_ajaran',
        'nilai_akhir',
        'deskripsi',
        'kelas_id',
        'rombel_id',
    ];

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }

    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    // 🔥 INI YANG WAJIB (PENYEBAB ERROR KAMU)
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // (opsional tapi disarankan)
    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }
}
