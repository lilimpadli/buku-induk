<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasGuru extends Model
{
    public function tugas() {
        return $this->hasMany(TugasGuru::class);
    }
}
