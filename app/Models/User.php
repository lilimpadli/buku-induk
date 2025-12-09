<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nomor_induk',   // kolom login
        'photo',
        'email',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Mengubah kolom login menjadi nomor_induk
     */
    public function getAuthIdentifierName()
    {
        return 'nomor_induk';
    }

    public function rombels()
{
    return $this->hasMany(Rombel::class, 'wali_kelas_id');
}

}
