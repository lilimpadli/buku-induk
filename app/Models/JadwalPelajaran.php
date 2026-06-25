<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    protected $table = 'jadwal_pelajarans';

    protected $fillable = [
        'tahun_ajaran_id',
        'semester_id',
        'rombel_id',
        'mata_pelajaran_id',
        'guru_id',
        'ruang_kelas_id',
        'hari',
        'jam_pelajaran_id',
        'jam_ke',
        'is_active',
        'keterangan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi ke Tahun Ajaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    // Relasi ke Semester
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    // Relasi ke Rombel (Kelas)
    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }

    // Relasi ke Mata Pelajaran
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    // Relasi ke Guru
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    // Relasi ke Ruang Kelas
    public function ruangKelas()
    {
        return $this->belongsTo(RuangKelas::class);
    }

    // Relasi ke Jam Pelajaran
    public function jamPelajaran()
    {
        return $this->belongsTo(JamPelajaran::class);
    }

    // Scope untuk filter berdasarkan rombel
    public function scopeByRombel($query, $rombelId)
    {
        return $query->where('rombel_id', $rombelId);
    }

    // Scope untuk filter berdasarkan hari
    public function scopeByHari($query, $hari)
    {
        return $query->where('hari', $hari);
    }

    // Scope untuk filter aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper untuk mendapatkan label
    public function getLabelAttribute()
    {
        return $this->hari . ' - ' . $this->jamPelajaran?->kode_jam . ' - ' . $this->mataPelajaran?->nama;
    }

    // Helper untuk mendapatkan waktu lengkap
    public function getWaktuAttribute()
    {
        return $this->hari . ' ' . $this->jamPelajaran?->waktu;
    }
}