<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Siswa Default',
                'nomor_induk' => '20250001',
                'email' => 'siswa@example.com',
                'role' => 'siswa',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Wali Kelas Default',
                'nomor_induk' => '1978123456',
                'email' => 'walikelas@example.com',
                'role' => 'walikelas',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Kaprog Default',
                'nomor_induk' => '1989456789',
                'email' => 'kaprog@example.com',
                'role' => 'kaprog',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'TU Default',
                'nomor_induk' => '1990332211',
                'email' => 'tu@example.com',
                'role' => 'tu',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Kurikulum Default',
                'nomor_induk' => '1977665544',
                'email' => 'kurikulum@example.com',
                'role' => 'kurikulum',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
