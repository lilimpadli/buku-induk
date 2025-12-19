<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * @property int $id
 * @property string $nomor_induk
 * @property string $name
 * @property string $nisn
 * @property string $role
 * @property string|null $photo
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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

    public function rombels()
    {
        return $this->belongsToMany(Rombel::class, 'gurus', 'user_id', 'rombel_id');
    }
public function waliKelas()
{
    return $this->hasMany(WaliKelas::class, 'user_id');
}

}
