<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisKelamin extends Model
{
    protected $table = 'jenis_kelamins';

    protected $fillable = [
        'nama',
    ];

    public function siswa()
    {
        return $this->hasMany(DataSiswa::class, 'jenis_kelamin_id');
    }
}
