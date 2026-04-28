<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    
    protected $table = 'jurusans'; // Nama tabel di database
    
    protected $fillable = [
        'kode',
        'nama',
        'id_bidang',
    ];
    // Relasi: satu jurusan milik satu bidang keahlian
    public function bidangKeahlian()
    {
        return $this->belongsTo(\App\Models\BidangKeahlian::class, 'id_bidang');
    }

    // Relasi: satu jurusan punya banyak kelas
    public function kelas()
    {
        return $this->hasMany(\App\Models\Kelas::class, 'jurusan_id');
    }

    // Relasi: satu jurusan punya banyak guru
    public function gurus()
    {
        return $this->hasMany(\App\Models\Guru::class, 'jurusan_id');
    }

    // Relasi: satu jurusan punya banyak mata pelajaran (many-to-many)
    public function mataPelajarans()
    {
        return $this->belongsToMany(MataPelajaran::class, 'jurusan_mata_pelajaran', 'jurusan_id', 'mata_pelajaran_id');
    }
}
