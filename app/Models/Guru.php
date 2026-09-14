<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'gurus';

    protected $fillable = [
        'nama',
        'nip',
        'nik',
        'nuptk',
        'serdik',
        'email_resmi',
        'email_pribadi',
        'status_keaktifan',
        'email',
        'telepon',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'pendidikan',
        'status_kepegawaian',
        'gelar_depan',
        'gelar_belakang',
        'alamat_jalan',
        'alamat',
        'rt',
        'rw',
        'dusun',
        'desa',
        'kecamatan',
        'kode_pos',
        'jurusan_id',
        'kelas_id',
        'user_id',
        'rombel_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }

    // Relasi ke Rombel yang Diampu (HasMany)
    public function rombels()
    {
        return $this->hasMany(Rombel::class, 'guru_id');
    }

    // Relasi ke Tugas Tambahan
    public function tugasTambahans()
    {
        return $this->hasMany(TugasTambahan::class, 'guru_id');
    }
}