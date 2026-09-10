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
        'kelas_id',
        'rombel_id',
        'pkl_nilai',
        'pkl_sertifikat',
        'pkl_nama_industri',
        'pkl_alamat',
        'ijazah_nomor',
        'ijazah_tanggal',
        'transkip_nomor',
        'transkip_tanggal',
        'tanggal_lulus',
        'status_kelulusan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function nilaiRaports()
    {
        return $this->hasMany(NilaiRaport::class, 'siswa_id');
    }

    public function mutasis()
    {
        return $this->hasMany(MutasiSiswa::class, 'siswa_id');
    }

    public function mutasiTerakhir()
    {
        return $this->hasOne(MutasiSiswa::class, 'siswa_id')->latestOfMany();
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }

    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id');
    }

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

    public function agama()
    {
        return $this->belongsTo(Agama::class, 'agama_id');
    }

    // 🔥 FIX: Tambahkan relasi ke kenaikan kelas
    public function kenaikanKelas()
    {
        return $this->hasMany(KenaikanKelas::class, 'siswa_id');
    }

    // 🔥 FIX: Relasi ke kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // 🔥 FIX: Accessor untuk nama lengkap (sudah ada)
    public function getNamaAttribute()
    {
        return $this->nama_lengkap;
    }
}