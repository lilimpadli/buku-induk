<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    
    protected $table = 'kelas'; // Nama tabel di database
    
    protected $fillable = [
        'tingkat',
        'jurusan_id',
    ];
    
    // Relasi dengan jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
    
    // Relasi dengan siswa
    public function siswa()
    {
        return $this->hasMany(DataSiswa::class, 'kelas_id', 'id');
    }

     public function rombels()
    {
        return $this->hasMany(Rombel::class, 'kelas_id');
    }

}