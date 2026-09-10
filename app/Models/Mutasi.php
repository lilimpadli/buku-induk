<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    protected $table = 'mutasis';

    // PERBAIKAN PENTING: Tambahkan 'nama_entitas' ke dalam array fillable
    protected $fillable = [
        'guru_id', 
        'nama_entitas', 
        'jenis', 
        'tanggal', 
        'keterangan'
    ];

    // Relasi ke Guru (karena di database kolomnya bernama guru_id)
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    // Relasi ke Dokumen Mutasi (jika ada)
    public function dokumenMutasi()
    {
        return $this->hasOne(DokumenMutasi::class, 'mutasi_id');
    }
}