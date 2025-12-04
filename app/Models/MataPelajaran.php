<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kelompok',
        'urutan',
    ];

    public function nilai()
    {
        return $this->hasMany(NilaiRaport::class, 'mata_pelajaran_id');
    }
}
