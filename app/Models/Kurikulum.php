<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;

    protected $table = 'kurikum';

    protected $fillable = [
        'nama_kurikulum',
    ];

    public function mataPelajarans()
    {
        return $this->belongsToMany(MataPelajaran::class, 'kurikulum_mata_pelajaran', 'kurikulum_id', 'mata_pelajaran_id');
    }
}
