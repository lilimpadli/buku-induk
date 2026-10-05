<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [
        // === VERSI BARU ===
        'nama',
        'nik',
        'nuptk',
        'nip',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'status_kepegawaian',
        'pendidikan',
        'tugas_tambahan',
        'email',
        'email_pribadi',
        'email_resmi',
        'no_hp',
        'jabatan',
        'alamat',
        'rt',
        'rw',
        'dusun',
        'desa',
        'kecamatan',
        'kode_pos',
        'user_id',

        // === VERSI LAMA (NOT NULL di DB) ===
        'nama_lengkap',
        'nip_nuptk',
        'jk',
        'tgl_lahir',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}