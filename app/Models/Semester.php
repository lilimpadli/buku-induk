<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semesters';
    protected $fillable = ['tahun_ajaran_id', 'semester', 'is_active', 'is_current', 'tanggal_mulai', 'tanggal_selesai', 'keterangan'];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    public function getSemesterNameAttribute()
    {
        return $this->semester == '1' ? 'Ganjil' : 'Genap';
    }

    public function getLabelAttribute()
    {
        $tahun = $this->tahunAjaran?->tahun ?? '-';
        $nama = $this->semester_name;
        $label = $nama . ' ' . $tahun;
        if ($this->is_current) {
            $label .= ' (Berjalan)';
        }
        return $label;
    }
    // ===== SAMPAI SINI =====
}