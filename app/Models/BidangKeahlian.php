<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidangKeahlian extends Model
{
    protected $table = 'bidang_keahlian';
    protected $fillable = [
        'nama_keahlian',
    ];
}
