<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutasiPegawai extends Model
{
    protected $table = 'mutasi_pegawais';
    protected $fillable = ['guru_id', 'jenis', 'tanggal', 'keterangan'];
    
    // Relasi ke tabel Guru
    public function pegawai()
    {
        // Mengarahkan ke Guru, dengan foreign key guru_id dan local key id
        return $this->belongsTo(Guru::class, 'guru_id', 'id');
    }
}