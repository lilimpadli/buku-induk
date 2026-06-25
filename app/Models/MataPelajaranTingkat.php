<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaranTingkat extends Model
{
    protected $table = 'mata_pelajaran_tingkat';
    protected $fillable = ['mata_pelajaran_id', 'tingkat', 'fase'];

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }
}