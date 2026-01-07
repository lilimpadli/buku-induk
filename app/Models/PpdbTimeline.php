<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpdbTimeline extends Model
{
    protected $table = 'ppdb_timelines';

    protected $fillable = [
        'stage',
        'title',
        'pendaftaran',
        'sanggah',
        'tes',
        'rapat',
        'pengumuman',
        'daftar_ulang',
        'open',
    ];

    protected $casts = [
        'open' => 'boolean',
    ];
}
