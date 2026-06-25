<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;
    
    protected $table = 'absensis';
    
    protected $fillable = [
        'siswa_id', 'tanggal', 'status', 'keterangan', 'input_by'
    ];
    
    protected $casts = [
        'tanggal' => 'date',
    ];
    
    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }
    
    public function inputter()
    {
        return $this->belongsTo(User::class, 'input_by');
    }
}