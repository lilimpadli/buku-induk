<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EkstrakurikulerSiswa extends Model
{
    protected $table = 'ekstrakurikuler_siswa'; // ← FIX PENTING

    protected $fillable = [
        'siswa_id',
        'nama_ekstra',
        'predikat',
        'keterangan',
    ];
}
