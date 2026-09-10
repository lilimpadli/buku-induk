<?php

namespace App\Console\Commands;

use App\Models\DataSiswa;
use App\Models\KenaikanKelas;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MoveLulusToKenaikanKelas extends Command
{
    protected $signature = 'move:lulus-to-kenaikan {--dry-run : Jalankan tanpa menyimpan perubahan}';
    protected $description = 'Pindahkan data siswa lulus ke tabel kenaikan_kelas (untuk alumni)';

    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        $this->info("=========================================");
        $this->info("📌 PINDAHKAN SISWA LULUS KE KENAIKAN_KELAS");
        $this->info("=========================================");

        if ($isDryRun) {
            $this->warn("⚠️ MODE DRY-RUN: Tidak ada perubahan yang disimpan.");
            $this->newLine();
        }

        // Ambil semua siswa yang statusnya lulus di mutasi_siswas
        $siswaLulus = DataSiswa::whereHas('mutasis', function($q) {
            $q->where('status', 'lulus');
        })->with(['mutasis' => function($q) {
            $q->where('status', 'lulus')->latest();
        }, 'rombel'])->get();

        if ($siswaLulus->isEmpty()) {
            $this->error("❌ Tidak ada siswa dengan status lulus.");
            return;
        }

        $this->info("📚 Ditemukan " . $siswaLulus->count() . " siswa lulus.");
        $this->newLine();

        $total = 0;
        $success = 0;
        $failed = 0;
        $skipped = 0;

        foreach ($siswaLulus as $siswa) {
            $total++;
            $mutasiLulus = $siswa->mutasis->first();

            $this->line("   📌 {$siswa->nama_lengkap} (NIS: {$siswa->nis})");

            // Cek apakah sudah ada di kenaikan_kelas
            $existing = KenaikanKelas::where('siswa_id', $siswa->id)
                ->where('status', 'Lulus')
                ->first();

            if ($existing) {
                $this->line("   ⏭️  Sudah ada di kenaikan_kelas, dilewati.");
                $skipped++;
                continue;
            }

            try {
                if ($isDryRun) {
                    $this->line("   🔍 [DRY-RUN] Akan dipindahkan ke kenaikan_kelas.");
                    $success++;
                } else {
                    DB::beginTransaction();

                    // Ambil data mutasi lulus
                    $tanggalMutasi = $mutasiLulus ? $mutasiLulus->tanggal_mutasi : Carbon::now();
                    $tahunAjaran = $this->getTahunAjaran($tanggalMutasi);
                    $semester = $this->getSemester($tanggalMutasi);

                    KenaikanKelas::create([
                        'siswa_id' => $siswa->id,
                        'semester' => $semester,
                        'tahun_ajaran' => $tahunAjaran,
                        'status' => 'Lulus',
                        'rombel_tujuan_id' => null,
                        'diproses_oleh' => null,
                        'tanggal_diproses' => Carbon::now(),
                        'catatan' => 'Lulus pada ' . $tanggalMutasi->format('d-m-Y') . ' (Otomatis dari command)',
                        'fase' => 'F',
                    ]);

                    DB::commit();
                    $success++;
                    $this->line("   ✅ Berhasil dipindahkan ke kenaikan_kelas.");
                }
            } catch (\Exception $e) {
                DB::rollBack();
                $failed++;
                $this->error("   ❌ Gagal: " . $e->getMessage());
            }
        }

        // Summary
        $this->newLine();
        $this->info("=========================================");
        $this->info("📊 SUMMARY");
        $this->info("=========================================");
        $this->info("Total siswa diproses : {$total}");
        $this->info("Berhasil             : {$success}");
        $this->info("Dilewati             : {$skipped}");
        $this->info("Gagal                : {$failed}");

        if ($isDryRun) {
            $this->newLine();
            $this->warn("⚠️ MODE DRY-RUN: Tidak ada perubahan yang disimpan.");
            $this->warn("⚠️ Jalankan tanpa --dry-run untuk menyimpan perubahan.");
        }

        $this->newLine();
        $this->info("✅ Selesai!");
    }

    /**
     * Tentukan tahun ajaran dari tanggal
     */
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

    /**
     * Tentukan semester dari tanggal
     */
    private function getSemester($tanggal)
    {
        $bulan = $tanggal->month;
        return ($bulan >= 7) ? 'Ganjil' : 'Genap';
    }
}