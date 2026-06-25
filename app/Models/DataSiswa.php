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
        'jenis_kelamin_id',
        'agama_id',
        'agama_lainnya',
        'kewarganegaraan',
        'status_keluarga',
        'anak_ke',
        'rt',
        'rw',
        'dusun',
        'kelurahan',
        'kecamatan',
        'kode_pos',
        'no_hp',
        'sekolah_asal',
        'tanggal_diterima',
        'ayah_id',
        'ibu_id',
        'wali_id',
        'foto',
        'catatan_wali_kelas',
        'rombel_id',
        'kurikulum_id',
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

    public function jenisKelamin()
    {
        return $this->belongsTo(JenisKelamin::class, 'jenis_kelamin_id');
    }

    public function agama()
    {
        return $this->belongsTo(Agama::class, 'agama_id');
    }

    /* ================================
     |  RELASI ROMBEL
     ================================= */
    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }

    /* ================================
     |  RELASI KURIKULUM
     ================================= */
    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class);
    }

    /* ================================
     |  RELASI KENAIKAN KELAS
     ================================= */
    public function kenaikanKelas()
    {
        return $this->hasMany(KenaikanKelas::class, 'siswa_id');
    }

    /* ================================
     |  RELASI MUTASI SISWA
     ================================= */
    public function mutasis()
    {
        return $this->hasMany(MutasiSiswa::class, 'siswa_id');
    }

    public function mutasiTerakhir()
    {
        return $this->hasOne(MutasiSiswa::class, 'siswa_id')->latestOfMany();
    }
}