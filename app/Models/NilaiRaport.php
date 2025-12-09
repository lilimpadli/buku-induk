<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NilaiRaport extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'mata_pelajaran_id',
        'semester',
        'tahun_ajaran',
        'nilai_akhir',
        'deskripsi',
    ];

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }

    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    
}
