<?php

namespace App\Console\Commands;

use App\Models\KenaikanKelas;
use App\Models\DataSiswa;
use App\Models\Jurusan;
use Illuminate\Console\Command;

class UpdateAlumniJurusan extends Command
{
    protected $signature = 'update:alumni-jurusan';
    protected $description = 'Update jurusan_id dan kelas_tingkat di kenaikan_kelas dari data siswa';

    public function handle()
    {
        $this->info("🔄 Update jurusan alumni...");

        $alumni = KenaikanKelas::where('status', 'Lulus')
            ->whereNull('jurusan_id')
            ->with('siswa.rombel.kelas.jurusan')
            ->get();

        $this->info("📚 Ditemukan " . $alumni->count() . " alumni tanpa jurusan.");

        $updated = 0;
        $skipped = 0;

        foreach ($alumni as $item) {
            $siswa = $item->siswa;

            if (!$siswa) {
                $skipped++;
                continue;
            }

            // Coba ambil jurusan dari rombel asal
            $rombel = $siswa->rombel;
            $jurusan = null;
            $kelasTingkat = null;

            if ($rombel && $rombel->kelas) {
                $kelas = $rombel->kelas;
                $jurusan = $kelas->jurusan;
                $kelasTingkat = $kelas->tingkat;
            }

            // Kalau tidak dapat dari rombel, coba dari mutasi terakhir
            if (!$jurusan) {
                $mutasiTerakhir = $siswa->mutasiTerakhir;
                if ($mutasiTerakhir && $mutasiTerakhir->rombelAsal) {
                    $rombelAsal = $mutasiTerakhir->rombelAsal;
                    if ($rombelAsal && $rombelAsal->kelas) {
                        $jurusan = $rombelAsal->kelas->jurusan;
                        $kelasTingkat = $rombelAsal->kelas->tingkat;
                    }
                }
            }

            if ($jurusan) {
                $item->jurusan_id = $jurusan->id;
                $item->kelas_tingkat = $kelasTingkat;
                $item->save();
                $updated++;
                $this->line("   ✅ Siswa: {$siswa->nama_lengkap} → Jurusan: {$jurusan->nama}");
            } else {
                $skipped++;
                $this->line("   ⏭️  Siswa: {$siswa->nama_lengkap} → Tidak ada jurusan");
            }
        }

        $this->newLine();
        $this->info("=========================================");
        $this->info("📊 SUMMARY");
        $this->info("=========================================");
        $this->info("Total alumni diproses : {$alumni->count()}");
        $this->info("Berhasil diupdate    : {$updated}");
        $this->info("Tidak ada data       : {$skipped}");
        $this->info("✅ Selesai!");
    }
}