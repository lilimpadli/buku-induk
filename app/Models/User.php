<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Rombel;


/**
 * @property int $id
 * @property string $name
 * @property string $nomor_induk
 * @property string $nisn
 * @property string $email
 * @property string $password
 * @property string|null $photo
 * @property string $role
 * @property string|null $remember_token
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    

    protected $fillable = [
        'name',
        'nomor_induk',
        'nisn',
        'photo',
        'email',
        'password',
        'role',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Mengubah kolom login menjadi nomor_induk
     */
    public function getAuthIdentifierName()
    {
        return 'nomor_induk';
    }

    

public function guru()
{
    return $this->hasOne(Guru::class, 'user_id');
}

public function rombels()
{
    return $this->belongsToMany(Rombel::class, 'gurus', 'user_id', 'rombel_id');
}

public function waliKelas()
{
    return $this->hasMany(WaliKelas::class, 'user_id');
}

}
