<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DataSiswa;
use Illuminate\Support\Facades\Log;

class MutasiSiswa extends Model
{
    use HasFactory;

    protected $table = 'mutasi_siswas';

    protected $fillable = [
        'siswa_id',
        'status',
        'tanggal_mutasi',
        'rombel_asal_id',
        'rombel_tujuan_id',
        'alasan_pindah',
        'tujuan_pindah',
        'sekolah_asal',
        'nis_dari_sekolah_asal',
        'tanggal_masuk',
        'no_surat_masuk',
        'no_sk_keluar',
        'tanggal_sk_keluar',
        'tahun_ajaran',
        'keterangan',
        'diproses_oleh'
    ];

    protected $dates = [
        'tanggal_mutasi',
        'tanggal_sk_keluar',
        'tanggal_masuk',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'tanggal_mutasi' => 'date',
        'tanggal_sk_keluar' => 'date',
        'tanggal_masuk' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($mutasi) {
            Log::info("Mutasi created: ID {$mutasi->id}, Status: {$mutasi->status}");
        });

        static::updated(function ($mutasi) {
            if ($mutasi->isDirty('status')) {
                Log::info("Mutasi updated: ID {$mutasi->id}, Status baru: {$mutasi->status}");
            }
        });
    }

    // Relasi
    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }

    public function rombelAsal()
    {
        return $this->belongsTo(Rombel::class, 'rombel_asal_id');
    }

    public function rombelTujuan()
    {
        return $this->belongsTo(Rombel::class, 'rombel_tujuan_id');
    }

    public function diprosesOleh()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeMasuk($query)
    {
        return $query->where('status', 'masuk');
    }

    public function scopeKeluar($query)
    {
        return $query->whereIn('status', ['pindah', 'do', 'meninggal', 'lulus']);
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        $labels = [
            'masuk' => 'Pindah Masuk',
            'pindah' => 'Pindah Sekolah',
            'do' => 'Keluar Sekolah',
            'meninggal' => 'Meninggal',
            'naik_kelas' => 'Naik Kelas',
            'lulus' => 'Lulus',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'masuk' => 'success',
            'pindah' => 'info',
            'do' => 'warning',
            'meninggal' => 'danger',
            'naik_kelas' => 'primary',
            'lulus' => 'secondary',
        ];
        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Apakah ini mutasi masuk?
     */
    public function getIsMasukAttribute()
    {
        return $this->status === 'masuk';
    }
}