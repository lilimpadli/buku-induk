<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataSiswa;
use App\Models\User;

class DataSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data siswa Ili
        $userIli = User::where('nomor_induk', '20250001')->first();
        DataSiswa::create([
            'user_id' => $userIli->id,
            'nama_lengkap' => 'Ili',
            'nis' => '20250001',
            'nisn' => '0051234567',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2005-05-15',
            'jenis_kelamin' => 'Perempuan',
            'agama' => 'Islam',
            'status_keluarga' => 'Anak Kandung',
            'anak_ke' => 1,
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            'no_hp' => '081234567890',
            'sekolah_asal' => 'SMPN 1 Jakarta',
            'kelas' => 'X MM 1',
            'tanggal_diterima' => '2023-07-17',
            'nama_ayah' => 'Ahmad Dahlan',
            'pekerjaan_ayah' => 'Pegawai Swasta',
            'telepon_ayah' => '081234567891',
            'nama_ibu' => 'Siti Aminah',
            'pekerjaan_ibu' => 'Ibu Rumah Tangga',
            'telepon_ibu' => '081234567892',
        ]);
        
        // Data siswa Wali
        $userWali = User::where('nomor_induk', '20250002')->first();
        DataSiswa::create([
            'user_id' => $userWali->id,
            'nama_lengkap' => 'Wali',
            'nis' => '20250002',
            'nisn' => '0051234568',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2005-08-20',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'status_keluarga' => 'Anak Kandung',
            'anak_ke' => 2,
            'alamat' => 'Jl. Pahlawan No. 15, Bandung',
            'no_hp' => '081234567893',
            'sekolah_asal' => 'SMPN 2 Bandung',
            'kelas' => 'X MM 1',
            'tanggal_diterima' => '2023-07-17',
            'nama_ayah' => 'Budi Santoso',
            'pekerjaan_ayah' => 'Wiraswasta',
            'telepon_ayah' => '081234567894',
            'nama_ibu' => 'Dewi Lestari',
            'pekerjaan_ibu' => 'Guru',
            'telepon_ibu' => '081234567895',
        ]);
        
        // Data siswa lainnya
        $siswaNames = ['Ahmad', 'Siti', 'Budi', 'Dewi', 'Eko', 'Fitri', 'Gunawan', 'Hana', 'Irfan', 'Julia'];
        $kelasOptions = ['X MM 1', 'X MM 2', 'X TKJ 1', 'X TKJ 2', 'XI MM 1', 'XI MM 2', 'XI TKJ 1', 'XI TKJ 2'];
        
        for ($i = 3; $i <= 12; $i++) {
            $user = User::where('nomor_induk', '202500' . str_pad($i, 2, '0', STR_PAD_LEFT))->first();
            $kelasIndex = ($i - 3) % count($kelasOptions);
            
            DataSiswa::create([
                'user_id' => $user->id,
                'nama_lengkap' => $siswaNames[$i-3],
                'nis' => '202500' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'nisn' => '005123456' . ($i + 2),
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => now()->subYears(15)->subDays(rand(1, 365))->format('Y-m-d'),
                'jenis_kelamin' => $i % 2 == 0 ? 'Perempuan' : 'Laki-laki',
                'agama' => 'Islam',
                'status_keluarga' => 'Anak Kandung',
                'anak_ke' => rand(1, 5),
                'alamat' => 'Jl. Contoh No. ' . $i . ', Jakarta',
                'no_hp' => '081234567' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'sekolah_asal' => 'SMPN ' . rand(1, 10) . ' Jakarta',
                'kelas' => $kelasOptions[$kelasIndex],
                'tanggal_diterima' => '2023-07-17',
                'nama_ayah' => 'Ayah ' . $siswaNames[$i-3],
                'pekerjaan_ayah' => 'Pegawai Swasta',
                'telepon_ayah' => '081234567' . str_pad($i + 10, 3, '0', STR_PAD_LEFT),
                'nama_ibu' => 'Ibu ' . $siswaNames[$i-3],
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'telepon_ibu' => '081234567' . str_pad($i + 20, 3, '0', STR_PAD_LEFT),
            ]);
        }
    }
}