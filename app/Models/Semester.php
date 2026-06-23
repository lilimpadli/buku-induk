<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semesters';
    protected $fillable = ['tahun_ajaran_id', 'semester', 'is_active'];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}