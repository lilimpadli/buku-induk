<?php

namespace App\Console\Commands;

use App\Models\DataSiswa;
use App\Models\KenaikanKelas;
use App\Models\MutasiSiswa;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SyncAlumni extends Command
{
    protected $signature = 'sync:alumni';
    protected $description = 'Sinkronkan data alumni dari mutasi lulus ke kenaikan_kelas';

    public function handle()
    {
        $this->info("🔄 Sync Alumni dimulai...");

        // Ambil semua siswa dengan status lulus di mutasi
        $siswaLulus = DataSiswa::whereHas('mutasis', function($q) {
            $q->where('status', 'lulus');
        })->with(['mutasis' => function($q) {
            $q->where('status', 'lulus')->latest();
        }])->get();

        $this->info("📚 Ditemukan " . $siswaLulus->count() . " siswa lulus di mutasi.");

        $total = 0;
        $success = 0;
        $failed = 0;
        $skipped = 0;

        foreach ($siswaLulus as $siswa) {
            $total++;

            // Cek apakah sudah ada di kenaikan_kelas dengan siswa_id yang benar
            $existing = KenaikanKelas::where('siswa_id', $siswa->id)
                ->where('status', 'Lulus')
                ->first();

            if ($existing) {
                $skipped++;
                $this->line("   ⏭️  Siswa {$siswa->nama_lengkap} (ID: {$siswa->id}) sudah ada.");
                continue;
            }

            try {
                $mutasiLulus = $siswa->mutasis->first();
                $tanggalMutasi = $mutasiLulus ? $mutasiLulus->tanggal_mutasi : Carbon::now();

                KenaikanKelas::create([
                    'siswa_id' => $siswa->id,
                    'semester' => 'Ganjil',
                    'tahun_ajaran' => $this->getTahunAjaran($tanggalMutasi),
                    'status' => 'Lulus',
                    'rombel_tujuan_id' => null,
                    'diproses_oleh' => null,
                    'tanggal_diproses' => Carbon::now(),
                    'catatan' => 'Lulus pada ' . $tanggalMutasi->format('d-m-Y'),
                ]);

                $success++;
                $this->line("   ✅ Siswa {$siswa->nama_lengkap} (ID: {$siswa->id}) berhasil ditambahkan.");
            } catch (\Exception $e) {
                $failed++;
                $this->error("   ❌ Gagal: " . $e->getMessage());
            }
        }

        // Summary
        $this->newLine();
        $this->info("=========================================");
        $this->info("📊 SUMMARY");
        $this->info("=========================================");
        $this->info("Total siswa lulus di mutasi: {$total}");
        $this->info("Berhasil ditambahkan       : {$success}");
        $this->info("Sudah ada (dilewati)       : {$skipped}");
        $this->info("Gagal                      : {$failed}");

        // Cek total alumni di kenaikan_kelas
        $totalAlumni = KenaikanKelas::where('status', 'Lulus')->count();
        $this->info("Total alumni di database   : {$totalAlumni}");

        $this->info("✅ Selesai!");
    }

    private function getTahunAjaran($tanggal)
    {
        $bulan = $tanggal->month;
        $tahun = $tanggal->year;

        if ($bulan >= 7) {
            return $tahun . '/' . ($tahun + 1);
        } else {
            return ($tahun - 1) . '/' . $tahun;
        }
    }
}