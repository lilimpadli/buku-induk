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
        'catatan',
        'rombel_tujuan_id',   // WAJIB ditambah
    ];

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class);
    }

    public function rombelTujuan()
    {
        return $this->belongsTo(Rombel::class, 'rombel_tujuan_id');
    }
}
