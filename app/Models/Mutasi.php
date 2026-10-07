<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    protected $table = 'mutasis';

    protected $fillable = [
        'guru_id',
        'tipe_entitas',
        'jenis',
        'tanggal',
        'keterangan',
        'nama_entitas',
        'nip',
        'nik',
        'nuptk',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'status_kepegawaian',
        'pendidikan',
        'serdik',
        'tugas_tambahan',
        'jabatan',
        'email',
        'email_pribadi',
        'email_resmi',
        'telepon',
        'alamat',
        'alamat_jalan',
        'rt',
        'rw',
        'dusun',
        'desa',
        'kecamatan',
        'kode_pos',
        'user_id_backup',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id')->withTrashed();
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'guru_id')->withTrashed();
    }

    public function dokumenMutasi()
    {
        return $this->hasOne(DokumenMutasi::class, 'mutasi_id');
    }
}