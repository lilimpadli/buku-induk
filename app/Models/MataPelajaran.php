<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kelompok',
        'urutan',
    ];

    public function nilai()
    {
        return $this->hasMany(NilaiRaport::class, 'mata_pelajaran_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function kurikulums()
    {
        return $this->belongsToMany(Kurikulum::class, 'kurikulum_mata_pelajaran', 'mata_pelajaran_id', 'kurikulum_id');
    }

    public function jurusans()
    {
        return $this->belongsToMany(Jurusan::class, 'jurusan_mata_pelajaran', 'mata_pelajaran_id', 'jurusan_id');
    }

    public function tingkats()
    {
        return $this->hasMany(MataPelajaranTingkat::class, 'mata_pelajaran_id');
    }
}
