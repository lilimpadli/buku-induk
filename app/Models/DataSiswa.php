<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSiswa extends Model
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
        'status_keluarga',
        'anak_ke',
        'alamat',
        'no_hp',
        'sekolah_asal',
        'kelas',
        'tanggal_diterima',
        'nama_ayah',
        'pekerjaan_ayah',
        'telepon_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'telepon_ibu',
        'alamat_orangtua',
        'nama_wali',
        'alamat_wali',
        'telepon_wali',
        'pekerjaan_wali',
        'foto',
        'catatan_wali_kelas',
        'rombel_id',
    ];

    /* ================================
     |  RELASI RAPOR
     ================================= */
    public function nilai()
    {
        return $this->hasMany(NilaiRaport::class, 'siswa_id');
    }

    // Tambahan untuk fix error: alias dari nilai()
    public function nilaiRaports()
    {
        return $this->hasMany(NilaiRaport::class, 'siswa_id');
    }

    public function ekstra()
    {
        return $this->hasMany(EkstrakurikulerSiswa::class, 'siswa_id');
    }

    public function kehadiran()
    {
        return $this->hasOne(Kehadiran::class, 'siswa_id');
    }

    public function raporInfo()
    {
        return $this->hasOne(RaporInfo::class, 'siswa_id');
    }

    /* ================================
     |  RELASI USER
     ================================= */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* ================================
     |  RELASI ROMBEL
     ================================= */
    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }
}

