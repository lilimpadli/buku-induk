<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    protected $fillable = [
        'kelas_id',
        'nama',
        'guru_id'
    ];

    // ✅ Relasi ke Guru (BUKAN User)
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function siswa()
    {
        return $this->hasMany(DataSiswa::class, 'rombel_id');
    }
}
