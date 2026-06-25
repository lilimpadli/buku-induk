<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    public function pegawai() {
    return $this->belongsTo(Pegawai::class);
}

}
