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
        'email',
        'telepon',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'pendidikan',           // Tambahkan ini jika belum ada
        'status_kepegawaian',   // WAJIB: Agar filter bisa bekerja
        'gelar_depan',
        'gelar_belakang',
        'alamat',
        'jurusan_id',
        'kelas_id',
        'user_id',
        'rombel_id',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    // Relasi ke Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // Relasi Rombel (Wali Kelas)
    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }

    // Relasi ke Tugas Tambahan
    public function tugasTambahans()
    {
        return $this->hasMany(TugasTambahan::class, 'guru_id');
    }
}