<?php

namespace App\Console\Commands;

use App\Models\DataSiswa;
use App\Models\MutasiSiswa;
use App\Models\Rombel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateKelasXiiToLulus extends Command
{
    protected $signature = 'update:kelas-xii-lulus {--tahun=2024/2025} {--dry-run}';
    protected $description = 'Update status mutasi siswa kelas XII menjadi LULUS';

    public function handle()
    {
        $tahunAjaran = $this->option('tahun') ?? '2024/2025';
        $isDryRun = $this->option('dry-run');

        $this->info("📌 Memproses siswa kelas XII tahun ajaran {$tahunAjaran}...");

        // Ambil semua rombel dengan tingkat XII
        $rombels = Rombel::whereHas('kelas', function($q) {
            $q->where('tingkat', 'XII');
        })->with('siswa')->get();

        if ($rombels->isEmpty()) {
            $this->error("❌ Tidak ada rombel kelas XII ditemukan.");
            return;
        }

        $totalSiswa = 0;
        $totalLulus = 0;
        $totalError = 0;

        foreach ($rombels as $rombel) {
            $this->info("\n📚 Rombel: {$rombel->nama}");

            foreach ($rombel->siswa as $siswa) {
                $totalSiswa++;

                // Cek apakah sudah ada mutasi LULUS sebelumnya
                $existingMutasi = MutasiSiswa::where('siswa_id', $siswa->id)
                    ->where('status', 'lulus')
                    ->first();

                if ($existingMutasi) {
                    $this->line("   ⏭️  Siswa {$siswa->nama_lengkap} (NIS: {$siswa->nis}) sudah LULUS, dilewati.");
                    continue;
                }

                try {
                    if ($isDryRun) {
                        // Dry-run: hanya tampilkan, tidak diupdate
                        $this->line("   🔍 [DRY-RUN] Siswa {$siswa->nama_lengkap} (NIS: {$siswa->nis}) akan diluluskan.");
                        $totalLulus++;
                    } else {
                        // Proses update ke LULUS
                        DB::beginTransaction();

                        // 1. Buat mutasi LULUS
                        MutasiSiswa::create([
                            'siswa_id' => $siswa->id,
                            'status' => 'lulus',
                            'tanggal_mutasi' => Carbon::now(),
                            'keterangan' => "Lulus pada tahun ajaran {$tahunAjaran}",
                            'rombel_asal_id' => $siswa->rombel_id,
                            'rombel_tujuan_id' => null,
                        ]);

                        // 2. Kosongkan rombel siswa (keluar dari kelas)
                        $siswa->rombel_id = null;
                        $siswa->save();

                        DB::commit();
                        $totalLulus++;
                        $this->line("   ✅ Siswa {$siswa->nama_lengkap} (NIS: {$siswa->nis}) berhasil diluluskan.");
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    $totalError++;
                    $this->error("   ❌ Gagal luluskan siswa {$siswa->nama_lengkap}: " . $e->getMessage());
                }
            }
        }

        // Summary
        $this->newLine();
        $this->info("=========================================");
        $this->info("📊 SUMMARY");
        $this->info("=========================================");
        $this->info("Total siswa diproses: {$totalSiswa}");
        $this->info("Total siswa diluluskan: {$totalLulus}");
        $this->info("Total error: {$totalError}");

        if ($isDryRun) {
            $this->warn("⚠️ Ini adalah DRY-RUN, tidak ada perubahan yang disimpan.");
        }

        $this->info("✅ Selesai!");
    }
}