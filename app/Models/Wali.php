<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wali extends Model
{
    protected $table = 'walis';
    protected $fillable = ['nama','pekerjaan','telepon','alamat'];

    public function siswa()
    {
        return $this->hasMany(DataSiswa::class, 'wali_id');
    }
}
