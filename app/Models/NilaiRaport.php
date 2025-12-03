<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiRaport extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'semester',
        'tahun_ajaran',
        'mata_pelajaran',
        'kkm',
        'nilai_pengetahuan',
        'nilai_keterampilan',
        'predikat_pengetahuan',
        'predikat_keterampilan',
        'deskripsi_pengetahuan',
        'deskripsi_keterampilan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}