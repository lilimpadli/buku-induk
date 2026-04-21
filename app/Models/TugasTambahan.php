<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasTambahan extends Model
{
    protected $table = 'tugas_tambahans';
    
    protected $fillable = [
        'guru_id',
        'tipe_tugas',
        'tahun_ajaran',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke Guru
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Relasi ke User melalui Guru
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'guru_id', 'id')->through('guru');
    }

    /**
     * Scope untuk filter berdasarkan tipe tugas
     */
    public function scopeByTipe($query, $tipe)
    {
        return $query->where('tipe_tugas', $tipe);
    }

    /**
     * Scope untuk filter berdasarkan tahun ajaran
     */
    public function scopeByTahunAjaran($query, $tahunAjaran)
    {
        return $query->where('tahun_ajaran', $tahunAjaran);
    }

    /**
     * Get label untuk tipe tugas
     */
    public static function getTipeLabel($tipe)
    {
        $labels = [
            'wali_kelas' => 'Wali Kelas',
            'waka_kesiswaan' => 'Waka Kesiswaan',
            'kaprog' => 'Kaprog',
        ];

        return $labels[$tipe] ?? $tipe;
    }

    /**
     * Get all available tipe tugas
     */
    public static function getAvailableTipes()
    {
        return [
            'wali_kelas' => 'Wali Kelas',
            'waka_kesiswaan' => 'Waka Kesiswaan',
            'kaprog' => 'Kaprog',
        ];
    }
}
