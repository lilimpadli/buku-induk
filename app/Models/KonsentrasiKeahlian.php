<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonsentrasiKeahlian extends Model
{
	protected $table = 'konsentrasi_keahlian';
	protected $fillable = [
		'nama_konsentrasi',
	];
}