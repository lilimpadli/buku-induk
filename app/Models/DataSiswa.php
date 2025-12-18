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
        'ayah_id',
        'ibu_id',
        'wali_id',
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
     |  RELASI ORANG TUA
     ================================= */
    public function ayah()
    {
        return $this->belongsTo(Ayah::class, 'ayah_id');
    }

    public function ibu()
    {
        return $this->belongsTo(Ibu::class, 'ibu_id');
    }

    public function wali()
    {
        return $this->belongsTo(Wali::class, 'wali_id');
    }

    /* ================================
     |  RELASI ROMBEL
     ================================= */
    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }
}