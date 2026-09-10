<?php

namespace App\Console\Commands;

use App\Models\DataSiswa;
use App\Models\MutasiSiswa;
use App\Models\Rombel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateKelasXiKeXii extends Command
{
    protected $signature = 'update:xi-ke-xii 
                            {--tahun=2025/2026 : Tahun ajaran}
                            {--dry-run : Jalankan tanpa menyimpan perubahan}';

    protected $description = 'Naikkan semua siswa kelas XI ke XII';

    public function handle()
    {
        $tahunAjaran = $this->option('tahun');
        $isDryRun = $this->option('dry-run');

        $this->info("=========================================");
        $this->info("📌 NAIKKAN SISWA KELAS XI → XII");
        $this->info("📌 Tahun Ajaran: {$tahunAjaran}");
        $this->info("=========================================");

        if ($isDryRun) {
            $this->warn("⚠️ MODE DRY-RUN: Tidak ada perubahan yang disimpan.");
            $this->newLine();
        }

        // Ambil semua rombel kelas XI
        $rombels = Rombel::whereHas('kelas', function($q) {
            $q->where('tingkat', 'XI');
        })->with(['siswa', 'kelas'])->get();

        if ($rombels->isEmpty()) {
            $this->error("❌ Tidak ada rombel kelas XI ditemukan.");
            return;
        }

        $this->info("📚 Ditemukan " . $rombels->count() . " rombel kelas XI.");

        $totalSiswa = 0;
        $totalNaik = 0;
        $totalError = 0;
        $totalSkipped = 0;

        foreach ($rombels as $rombel) {
            $this->newLine();
            $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->info("📚 Rombel Asal: {$rombel->nama}");

            // Cari rombel tujuan (XII dengan nama yang sama)
            $baseName = preg_replace('/^(XI|11)\s*/i', '', $rombel->nama);
            $baseName = trim($baseName);

            $rombelTujuan = Rombel::whereHas('kelas', function($q) {
                $q->where('tingkat', 'XII');
            })->where(function($q) use ($rombel, $baseName) {
                $q->where('nama', $rombel->nama)
                  ->orWhere('nama', 'like', '%' . $baseName . '%')
                  ->orWhere('nama', 'like', '%' . preg_replace('/\s+/', ' ', $baseName) . '%');
            })->first();

            if (!$rombelTujuan) {
                $this->warn("   ⚠️ Tidak ditemukan rombel tujuan untuk {$rombel->nama}");
                $this->warn("   ⚠️ Mencari dengan base name: '{$baseName}'");
                $this->warn("   ⚠️ Rombel ini dilewati.");
                $totalSkipped++;
                continue;
            }

            $this->info("   ➡️  Rombel Tujuan: {$rombelTujuan->nama} (ID: {$rombelTujuan->id})");
            $this->line("   👨‍🎓 Jumlah siswa: " . $rombel->siswa->count());

            foreach ($rombel->siswa as $siswa) {
                $totalSiswa++;

                // Cek apakah sudah ada mutasi naik_kelas ke XII
                $existingMutasi = MutasiSiswa::where('siswa_id', $siswa->id)
                    ->where('status', 'naik_kelas')
                    ->where('rombel_tujuan_id', $rombelTujuan->id)
                    ->first();

                if ($existingMutasi) {
                    $totalSkipped++;
                    $this->line("   ⏭️  {$siswa->nama_lengkap} (NIS: {$siswa->nis}) sudah naik, dilewati.");
                    continue;
                }

                try {
                    if ($isDryRun) {
                        $this->line("   🔍 [DRY-RUN] {$siswa->nama_lengkap} (NIS: {$siswa->nis}) → {$rombelTujuan->nama}");
                        $totalNaik++;
                    } else {
                        DB::beginTransaction();

                        // 1. Buat mutasi NAIK KELAS
                        MutasiSiswa::create([
                            'siswa_id' => $siswa->id,
                            'status' => 'naik_kelas',
                            'tanggal_mutasi' => Carbon::now(),
                            'keterangan' => "Naik dari XI ke XII tahun ajaran {$tahunAjaran}",
                            'rombel_asal_id' => $siswa->rombel_id,
                            'rombel_tujuan_id' => $rombelTujuan->id,
                        ]);

                        // 2. Update rombel siswa ke tujuan
                        $siswa->rombel_id = $rombelTujuan->id;
                        $siswa->save();

                        DB::commit();
                        $totalNaik++;
                        $this->line("   ✅ {$siswa->nama_lengkap} (NIS: {$siswa->nis}) → {$rombelTujuan->nama}");
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    $totalError++;
                    $this->error("   ❌ Gagal: {$siswa->nama_lengkap} - " . $e->getMessage());
                }
            }
        }

        // ============================================================
        // SUMMARY
        // ============================================================
        $this->newLine();
        $this->info("=========================================");
        $this->info("📊 SUMMARY - NAIK XI → XII");
        $this->info("=========================================");
        $this->info("Total siswa diproses     : {$totalSiswa}");
        $this->info("Total siswa naik kelas   : {$totalNaik}");
        $this->info("Total siswa dilewati     : {$totalSkipped}");
        $this->info("Total error              : {$totalError}");

        if ($isDryRun) {
            $this->newLine();
            $this->warn("⚠️ MODE DRY-RUN: Tidak ada perubahan yang disimpan.");
            $this->warn("⚠️ Jalankan tanpa --dry-run untuk menyimpan perubahan.");
        }

        $this->newLine();
        $this->info("✅ Selesai!");
    }
}