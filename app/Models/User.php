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

    protected $fillable = [
        'name',
        'nomor_induk',
        'nisn',
        'photo',
        'email',
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
