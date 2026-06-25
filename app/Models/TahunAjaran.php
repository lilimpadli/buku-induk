<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajarans';
    protected $fillable = ['tahun', 'tanggal_mulai', 'tanggal_selesai', 'is_active'];

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }

    public function getActiveSemester()
    {
        return $this->semesters()->where('is_active', true)->first();
    }
}