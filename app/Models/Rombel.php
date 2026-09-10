<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;

    protected $table = 'rombels';

    protected $fillable = [
        'kelas_id',
        'id_konke',
        'nama',
        'guru_id',      // ⭐ PASTIKAN INI ADA
        'tahun_ajaran',
    ];

    // ⭐ TAMBAHKAN ACCESSOR INI (jika belum ada)
    public function getDisplayNameAttribute(): string
    {
        $nama = trim((string) ($this->nama ?? ''));
        $tingkat = trim((string) optional($this->kelas)->tingkat);

        if ($tingkat === '') {
            return $nama;
        }

        $namaTanpaTingkat = preg_replace('/^\s*(X|XI|XII)\s+/iu', '', $nama);
        $namaTanpaTingkat = trim((string) $namaTanpaTingkat);

        if ($namaTanpaTingkat === '') {
            return $tingkat;
        }

        return $tingkat . ' ' . $namaTanpaTingkat;
    }

    // ⭐ RELASI KE GURU (Wali Kelas)
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    
    public function siswa()
    {
        return $this->hasMany(DataSiswa::class, 'rombel_id');
    }

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'rombel_id');
    }

    public function konsentrasiKeahlian()
    {
        return $this->belongsTo(KonsentrasiKeahlian::class, 'id_konke');
    }

    public function dataSiswa()
    {
        return $this->hasMany(DataSiswa::class, 'rombel_id');
    }

    public function kenaikanKelas()
    {
        return $this->hasMany(KenaikanKelas::class, 'rombel_tujuan_id');
    }

    public function mutasiAsal()
    {
        return $this->hasMany(MutasiSiswa::class, 'rombel_asal_id');
    }

    public function mutasiTujuan()
    {
        return $this->hasMany(MutasiSiswa::class, 'rombel_tujuan_id');
    }
}