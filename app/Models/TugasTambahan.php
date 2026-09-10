<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasTambahan extends Model
{
    use HasFactory;

    protected $table = 'tugas_tambahan';

    protected $fillable = [
        'guru_id',
        'pegawai_id',
        'nama_tugas',
        'instansi',
        'mulai',
        'is_tugas_tambahan',
    ];

    protected $casts = [
        'mulai' => 'date',
        'is_tugas_tambahan' => 'boolean',
    ];

    /**
     * Relasi ke Guru
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    /**
     * 
     * \Relasi ke Pegawai
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}