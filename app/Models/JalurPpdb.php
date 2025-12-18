<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JalurPpdb extends Model
{
    protected $table = 'jalur_ppdb';
    protected $fillable = ['nama_jalur'];

    public function ppdb()
    {
        return $this->hasMany(Ppdb::class);
    }
}
