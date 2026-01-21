<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutasiSiswa extends Model
{
    protected $table = 'mutasi_siswas';

    protected $fillable = [
        'siswa_id',
        'status',
        'tanggal_mutasi',
        'keterangan',
        'alasan_pindah',
        'no_sk_keluar',
        'tanggal_sk_keluar',
        'tujuan_pindah',
    ];

    protected $dates = [
        'tanggal_mutasi',
        'tanggal_sk_keluar',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'tanggal_mutasi' => 'date',
        'tanggal_sk_keluar' => 'date',
    ];

    /**
     * Relationship dengan Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Scopes untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePindah($query)
    {
        return $query->where('status', 'pindah');
    }

    public function scopeDo($query)
    {
        return $query->where('status', 'do');
    }

    public function scopeMeninggal($query)
    {
        return $query->where('status', 'meninggal');
    }

    public function scopeNaikKelas($query)
    {
        return $query->where('status', 'naik_kelas');
    }

    public function scopeLulus($query)
    {
        return $query->where('status', 'lulus');
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pindah' => 'Pindah Sekolah',
            'do' => 'Putus Sekolah (DO)',
            'meninggal' => 'Meninggal Dunia',
            'naik_kelas' => 'Naik Kelas',
            'lulus' => 'Lulus',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'pindah' => 'info',
            'do' => 'warning',
            'meninggal' => 'danger',
            'naik_kelas' => 'success',
            'lulus' => 'primary',
        ];

        return $colors[$this->status] ?? 'secondary';
    }
}
