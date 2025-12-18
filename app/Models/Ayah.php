<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ayah extends Model
{
    protected $table = 'ayahs';
    protected $fillable = ['nama','pekerjaan','telepon','alamat'];

    public function siswa()
    {
        return $this->hasMany(DataSiswa::class, 'ayah_id');
    }
}
