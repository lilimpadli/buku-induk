<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KenaikanKelas extends Model
{
    protected $table = 'kenaikan_kelas';

    protected $fillable = [
        'siswa_id',
        'semester',
        'tahun_ajaran',
        'status',
        'rombel_tujuan_id',
        'diproses_oleh',
        'tanggal_diproses',
        'catatan',
    ];

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }

    public function rombelTujuan()
    {
        return $this->belongsTo(Rombel::class, 'rombel_tujuan_id');
    }

    public function diprosesOleh()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }
}
