<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KenaikanKelas extends Model
{
    protected $table = 'kenaikan_kelas';

    protected $fillable = [
        'siswa_id',
        'jurusan_id',
        'kelas_tingkat',
        'semester',
        'tahun_ajaran',
        'status',
        'rombel_tujuan_id',
        'diproses_oleh',
        'tanggal_diproses',
        'catatan',
    ];

    // 🔥 FIX: Relasi ke siswa menggunakan model yang benar
    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function rombelTujuan()
    {
        return $this->belongsTo(Rombel::class, 'rombel_tujuan_id');
    }

    public function diprosesOleh()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    // 🔥 FIX: Tambahkan scope untuk filter
    public function scopeLulus($query)
    {
        return $query->where('status', 'Lulus');
    }

    public function scopeByJurusan($query, $jurusanId)
    {
        return $query->where('jurusan_id', $jurusanId);
    }

    public function scopeByTahunAjaran($query, $tahunAjaran)
    {
        return $query->where('tahun_ajaran', $tahunAjaran);
    }

    // 🔥 FIX: Accessor untuk menampilkan nama siswa
    public function getNamaSiswaAttribute()
    {
        return $this->siswa ? $this->siswa->nama_lengkap : 'Tidak Diketahui';
    }

    // 🔥 FIX: Accessor untuk menampilkan nama jurusan
    public function getNamaJurusanAttribute()
    {
        return $this->jurusan ? $this->jurusan->nama : 'Belum Teridentifikasi';
    }
}