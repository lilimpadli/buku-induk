<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NilaiRaport;

class Siswa extends Model
{
    protected $table = 'data_siswa';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nis',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function nilaiRaports()
    {
        return $this->hasMany(NilaiRaport::class, 'siswa_id');
    }
}