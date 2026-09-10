<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenMutasi extends Model
{
    // Pastikan fillable diatur sesuai kolom yang Anda gunakan
    protected $fillable = [
        'mutasi_id', 
        'nama_dokumen', 
        'file_path'
    ];
}