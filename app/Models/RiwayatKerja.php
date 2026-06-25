<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatKerja extends Model
{
    protected $table = 'riwayat_kerjas';

    protected $fillable = ['instansi', 'jabatan', 'mulai'];
}