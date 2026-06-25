<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    public function administrasi() {
    return $this->hasMany(Administrasi::class);
}

public function absensi() {
    return $this->hasMany(Absensi::class);
}

public function dokumen() {
    return $this->hasMany(Dokumen::class);
}

protected $fillable = [
    'nama_lengkap', 'nip_nuptk', 'jk', 'tempat_lahir', 'tgl_lahir', 
    'alamat', 'no_hp', 'jabatan', 'status_kepegawaian', 'mapel', 'foto'
];

}
