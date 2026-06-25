<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamPelajaran extends Model
{
    protected $table = 'jam_pelajarans';

    protected $fillable = [
        'kode_jam',
        'jam_mulai',
        'jam_selesai',
        'urutan',
        'is_active',
        'keterangan',
    ];

    protected $casts = [
        'jam_mulai' => 'string',
        'jam_selesai' => 'string',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan', 'asc');
    }

    public function getWaktuAttribute()
    {
        return date('H:i', strtotime($this->jam_mulai)) . ' - ' . date('H:i', strtotime($this->jam_selesai));
    }

    public function getLabelAttribute()
    {
        return $this->kode_jam . ' (' . $this->waktu . ')';
    }
}