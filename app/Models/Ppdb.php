<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ppdb extends Model
{
    protected $table = 'ppdb';

    protected $fillable = [
        'nama_lengkap',
        'nis',
        'nisn',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'jalur_ppdb_id',
        'sesi_ppdb_id',
        'jurusan_id',
        'kelas_id',
        'rombel_id',
        'tahun_ajaran',
        'tanggal_diterima',
        'foto',
        'kk',
        'akta',
        'ijazah',
        'bukti_jalur',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Jika status diset menjadi 'diterima' dan tanggal_diterima kosong, isi dengan hari ini
            if ($model->status === 'diterima' && empty($model->tanggal_diterima)) {
                $model->tanggal_diterima = now()->toDateString();
            }
        });

        static::updating(function ($model) {
            // Jika status diubah menjadi 'diterima' dan tanggal_diterima kosong, isi dengan hari ini
            if ($model->status === 'diterima' && empty($model->tanggal_diterima) && $model->isDirty('status')) {
                $model->tanggal_diterima = now()->toDateString();
            }
        });
    }

    public function jalur()
    {
        return $this->belongsTo(JalurPpdb::class);
    }

    public function sesi()
    {
        return $this->belongsTo(SesiPpdb::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(\App\Models\Jurusan::class, 'jurusan_id');
    }
}
