<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NilaiRaport;
use App\Models\DataSiswa;
use App\Models\MataPelajaran;

class NilaiRaportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $siswas = DataSiswa::all();
        $mataPelajaran = MataPelajaran::all();
        
        foreach ($siswas as $siswa) {
            // Buat nilai untuk semester ganjil
            foreach ($mataPelajaran as $mapel) {
                $nilai = rand(70, 100);
                $predikat = $nilai >= 90 ? 'A' : ($nilai >= 80 ? 'B' : ($nilai >= 70 ? 'C' : 'D'));
                
                NilaiRaport::create([
                    'siswa_id' => $siswa->id,
                    'semester' => 'Ganjil',
                    'tahun_ajaran' => '2023/2024',
                    'mata_pelajaran' => $mapel->nama,
                    'kkm' => $mapel->kkm,
                    'nilai_pengetahuan' => $nilai,
                    'nilai_keterampilan' => $nilai - rand(0, 5),
                    'predikat_pengetahuan' => $predikat,
                    'predikat_keterampilan' => $predikat,
                    'deskripsi_pengetahuan' => 'Mampu menguasai materi ' . strtolower($mapel->nama) . ' dengan baik',
                    'deskripsi_keterampilan' => 'Terampil dalam praktikum ' . strtolower($mapel->nama),
                ]);
            }
            
            // Buat nilai untuk semester genap (hanya untuk beberapa siswa)
            if ($siswa->id <= 5) {
                foreach ($mataPelajaran as $mapel) {
                    $nilai = rand(70, 100);
                    $predikat = $nilai >= 90 ? 'A' : ($nilai >= 80 ? 'B' : ($nilai >= 70 ? 'C' : 'D'));
                    
                    NilaiRaport::create([
                        'siswa_id' => $siswa->id,
                        'semester' => 'Genap',
                        'tahun_ajaran' => '2023/2024',
                        'mata_pelajaran' => $mapel->nama,
                        'kkm' => $mapel->kkm,
                        'nilai_pengetahuan' => $nilai,
                        'nilai_keterampilan' => $nilai - rand(0, 5),
                        'predikat_pengetahuan' => $predikat,
                        'predikat_keterampilan' => $predikat,
                        'deskripsi_pengetahuan' => 'Mampu menguasai materi ' . strtolower($mapel->nama) . ' dengan baik',
                        'deskripsi_keterampilan' => 'Terampil dalam praktikum ' . strtolower($mapel->nama),
                    ]);
                }
            }
        }
    }
}