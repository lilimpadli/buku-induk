<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuangKelas extends Model
{
    protected $table = 'ruang_kelas';

    protected $fillable = [
        'kode_ruang',
        'nama_ruang',
        'lantai',
        'gedung',
        'kapasitas',
        'jenis_ruang',
        'fasilitas',
        'is_active',
        'keterangan',
    ];

    protected $casts = [
        'kapasitas' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getLabelAttribute()
    {
        return $this->kode_ruang . ' - ' . $this->nama_ruang;
    }

    public function getFullAttribute()
    {
        $text = $this->nama_ruang;
        if ($this->gedung) {
            $text .= ' (Gedung ' . $this->gedung . ')';
        }
        if ($this->lantai) {
            $text .= ' Lantai ' . $this->lantai;
        }
        return $text;
    }
}