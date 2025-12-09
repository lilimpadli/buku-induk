<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    protected $fillable = ['kelas_id', 'nama', 'wali_kelas_id'];

    public function waliKelas()
{
    return $this->belongsTo(User::class, 'wali_kelas_id');
}
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function siswa()
    {
        return $this->hasMany(DataSiswa::class, 'rombel_id');
    }


}
