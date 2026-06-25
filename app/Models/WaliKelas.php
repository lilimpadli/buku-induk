<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    use HasFactory;

    protected $table = 'gurus';

    protected $fillable = [
        'user_id',
        'kelas_id',
        'jurusan_id',
        'rombel_id',
        'tahun_ajaran',
        'semester',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function rombel()
    {
        // The `gurus` table doesn't have a `rombel_id` column.
        // Rombel records reference the guru via `guru_id`, so provide
        // a hasOne (primary rombel) and hasMany (all rombels) relations.
        return $this->hasOne(Rombel::class, 'guru_id', 'id');
    }

    public function rombels()
    {
        return $this->hasMany(Rombel::class, 'guru_id', 'id');
    }

    public function getRombelId()
    {
        // Ambil rombel yang memiliki guru_id = id wali kelas
        $rombel = Rombel::where('guru_id', $this->id)->first();
        return $rombel ? $rombel->id : null;
    }

    public function getSiswa()
    {
        $rombelId = $this->getRombelId();
        if (!$rombelId) {
            return collect();
        }
        return DataSiswa::where('rombel_id', $rombelId)->get();
}
}