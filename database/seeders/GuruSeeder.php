<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guru;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test guru user accounts
        $guruData = [
            [
                'name' => 'Ibu Siti Nurhaliza',
                'nomor_induk' => 'GU001',
                'nisn' => '',
                'email' => 'siti.nurhaliza@school.com',
                'password' => 'password123',
                'role' => 'guru',
                'guru' => [
                    'nama' => 'Siti Nurhaliza',
                    'nip' => '197501051998032003',
                    'email' => 'siti.nurhaliza@school.com',
                    'telepon' => '082123456789',
                    'tempat_lahir' => 'Jakarta',
                    'tanggal_lahir' => '1975-01-05',
                    'jenis_kelamin' => 'P',
                    'alamat' => 'Jl. Merpati No. 5, Jakarta Selatan',
                ]
            ],
            [
                'name' => 'Bapak Ahmad Wijaya',
                'nomor_induk' => 'GU002',
                'nisn' => '',
                'email' => 'ahmad.wijaya@school.com',
                'password' => 'password123',
                'role' => 'guru',
                'guru' => [
                    'nama' => 'Ahmad Wijaya',
                    'nip' => '196805121990031001',
                    'email' => 'ahmad.wijaya@school.com',
                    'telepon' => '081234567890',
                    'tempat_lahir' => 'Bandung',
                    'tanggal_lahir' => '1968-05-12',
                    'jenis_kelamin' => 'L',
                    'alamat' => 'Jl. Kebon Jeruk No. 12, Jakarta Barat',
                ]
            ],
            [
                'name' => 'Ibu Rahma Santoso',
                'nomor_induk' => 'GU003',
                'nisn' => '',
                'email' => 'rahma.santoso@school.com',
                'password' => 'password123',
                'role' => 'guru',
                'guru' => [
                    'nama' => 'Rahma Santoso',
                    'nip' => '197203151999032001',
                    'email' => 'rahma.santoso@school.com',
                    'telepon' => '085678901234',
                    'tempat_lahir' => 'Surabaya',
                    'tanggal_lahir' => '1972-03-15',
                    'jenis_kelamin' => 'P',
                    'alamat' => 'Jl. Cendana No. 8, Jakarta Timur',
                ]
            ],
        ];

        foreach ($guruData as $data) {
            // Extract guru data
            $guruInfo = $data['guru'];
            unset($data['guru']);

            // Create user
            $user = User::create([
                'name' => $data['name'],
                'nomor_induk' => $data['nomor_induk'],
                'nisn' => $data['nisn'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
            ]);

            // Create guru profile
            Guru::create([
                'user_id' => $user->id,
                ...$guruInfo
            ]);

            echo "✓ Guru account created: {$user->name} (No. Induk: {$user->nomor_induk})\n";
        }

        echo "\n=== Akun Guru Berhasil Dibuat ===\n";
        echo "Gunakan login berikut untuk akses:\n";
        echo "1. Nomor Induk: GU001 | Password: password123\n";
        echo "2. Nomor Induk: GU002 | Password: password123\n";
        echo "3. Nomor Induk: GU003 | Password: password123\n";
    }
}
