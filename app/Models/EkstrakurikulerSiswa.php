<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EkstrakurikulerSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'nama_ekstra',
        'predikat',
        'keterangan',
    ];

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }
}
