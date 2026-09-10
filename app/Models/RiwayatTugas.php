<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatTugas extends Model
{
    protected $table = 'riwayat_tugas'; 
    
    protected $fillable = [
        'pegawai_id', 
        'instansi', 
        'jabatan', 
        'mulai', 
        'is_tugas_tambahan'
    ];

    /**
     * Relasi ke model Pegawai
     * Ini yang membuat nama pegawai muncul di tabel index
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}