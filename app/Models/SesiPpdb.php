<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiPpdb extends Model
{
    protected $table = 'sesi_ppdb';
    protected $fillable = ['nama_sesi', 'tahun_ajaran', 'stage'];

    protected $casts = [
        'stage' => 'string',
    ];

    public function ppdb()
    {
        return $this->hasMany(Ppdb::class);
    }
}
