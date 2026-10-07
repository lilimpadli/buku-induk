<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pegawais';

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

        // === VERSI LAMA (NOT NULL di DB) — WAJIB DIPERTAHANKAN ===
        'nama_lengkap',
        'nip_nuptk',
        'jk',
        'tgl_lahir',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mutasis()
    {
        return $this->hasMany(Mutasi::class, 'guru_id');
    }
}