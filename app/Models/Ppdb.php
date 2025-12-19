<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ppdb extends Model
{
    protected $table = 'ppdb';

    protected $fillable = [
        'nama_lengkap',
        'nis',
        'nisn',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'jalur_ppdb_id',
        'sesi_ppdb_id',
        'jurusan_id',
        'kelas_id',
        'rombel_id',
        'tahun_ajaran',
        'tanggal_diterima',
        'foto',
        'kk',
        'akta',
        'ijazah',
        'bukti_jalur',
        'status'
    ];

    public function jalur()
    {
        return $this->belongsTo(JalurPpdb::class);
    }

    public function sesi()
    {
        return $this->belongsTo(SesiPpdb::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(\App\Models\Jurusan::class, 'jurusan_id');
    }
}
