<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    /**
     *
     */
    protected $fillable = [
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
        'no_hp',
        'jabatan',
        'alamat',
        'user_id',
    ];

    /**
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}