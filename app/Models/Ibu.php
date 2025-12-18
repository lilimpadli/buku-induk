<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ibu extends Model
{
    protected $table = 'ibus';
    protected $fillable = ['nama','pekerjaan','telepon','alamat'];

    public function siswa()
    {
        return $this->hasMany(DataSiswa::class, 'ibu_id');
    }
}
