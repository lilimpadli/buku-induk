<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MataPelajaranTingkat extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran_tingkat';

    protected $fillable = [
        'mata_pelajaran_id',
        'tingkat',
    ];

    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }
}
