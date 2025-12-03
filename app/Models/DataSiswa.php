<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSiswa extends Model
{
    protected $table = 'data_siswa';

    protected $fillable = [
        'user_id', 'nama_lengkap', 'nis', 'nisn', 'jenis_kelamin', 'tempat_lahir',
        'tanggal_lahir', 'agama', 'status_keluarga', 'anak_ke', 'alamat', 'no_hp',
        'sekolah_asal', 'kelas', 'tanggal_diterima',
        'nama_ayah', 'pekerjaan_ayah', 'telepon_ayah',
        'nama_ibu', 'pekerjaan_ibu', 'telepon_ibu',
        'nama_wali', 'alamat_wali', 'telepon_wali', 'pekerjaan_wali',
        'foto'
    ];
}
