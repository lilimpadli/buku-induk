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
        'no_sk_keluar',
        'tanggal_sk_keluar',
        'keterangan',
        'diproses_oleh'
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

    // 🔥 FIX: Boot method
    protected static function boot()
    {
        parent::boot();

        static::created(function ($mutasi) {
            Log::info("Mutasi created: ID {$mutasi->id}, Status: {$mutasi->status}");
            // Biarkan observer yang menangani
        });

        static::updated(function ($mutasi) {
            if ($mutasi->isDirty('status')) {
                Log::info("Mutasi updated: ID {$mutasi->id}, Status baru: {$mutasi->status}");
                // Biarkan observer yang menangani
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

    // Accessors
    public function getStatusLabelAttribute()
    {
        $labels = [
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
            'pindah' => 'info',
            'do' => 'warning',
            'meninggal' => 'danger',
            'naik_kelas' => 'success',
            'lulus' => 'primary',
        ];
        return $colors[$this->status] ?? 'secondary';
    }
}