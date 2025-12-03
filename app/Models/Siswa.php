<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'data_siswa';

    // Tambahkan 'user_id' ke dalam fillable
    protected $fillable = [
        'user_id', // <-- TAMBAHKAN INI
        'nama_lengkap',
        'nis',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
    ];

    /**
     * Relasi ke model User (One-to-One).
     * Data siswa ini dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}