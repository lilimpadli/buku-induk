<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kehadiran extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'sakit',
        'izin',
        'tanpa_keterangan',
        'semester',
        'tahun_ajaran',
    ];

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }
}
