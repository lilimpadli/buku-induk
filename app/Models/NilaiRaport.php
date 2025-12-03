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
    'nilai_pengetahuan',
    'deskripsi_pengetahuan',
];


    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
