<?php

namespace App\Console\Commands;

use App\Models\MutasiSiswa;
use App\Models\KenaikanKelas;
use App\Models\Guru;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SyncLulusToAlumni extends Command
{
    protected $signature = 'sync:lulus-to-alumni';
    protected $description = 'Pindahkan semua siswa dengan status mutasi LULUS ke tabel alumni (kenaikan_kelas)';

    public function handle()
    {
        $this->info("=========================================");
        $this->info("📌 SYNC MUTASI LULUS → ALUMNI");
        $this->info("=========================================");

        // Ambil semua mutasi dengan status lulus
        $mutasiLulus = MutasiSiswa::where('status', 'lulus')->get();
        
        if ($mutasiLulus->isEmpty()) {
            $this->error("❌ Tidak ada mutasi dengan status LULUS.");
            return;
        }

        $this->info("📚 Ditemukan " . $mutasiLulus->count() . " mutasi LULUS.\n");

        $success = 0;
        $failed = 0;
        $skipped = 0;

        foreach ($mutasiLulus as $mutasi) {
            $siswa = $mutasi->siswa;
            
            if (!$siswa) {
                $this->error("❌ Siswa tidak ditemukan untuk mutasi ID: {$mutasi->id}");
                $failed++;
                continue;
            }

            // Cek apakah sudah ada di alumni
            $exists = KenaikanKelas::where('siswa_id', $siswa->id)
                ->where('status', 'lulus')
                ->exists();

            if ($exists) {
                $this->line("⏭️  {$siswa->nama_lengkap} (NIS: {$siswa->nis}) - SUDAH ADA di alumni");
                $skipped++;
                continue;
            }

            try {
                // Ambil jurusan dan kelas
                $jurusanId = null;
                $kelasTingkat = null;
                $previousRombelId = $siswa->rombel_id;

                if ($siswa->rombel && $siswa->rombel->kelas) {
                    $jurusanId = $siswa->rombel->kelas->jurusan_id;
                    $kelasTingkat = $siswa->rombel->kelas->tingkat;
                }

                // LEPAS WALI KELAS (jika kelas XII)
                if ($siswa->rombel && $kelasTingkat === 'XII') {
                    $rombel = $siswa->rombel;
                    $guruId = $rombel->guru_id;
                    
                    if ($guruId) {
                        $rombel->guru_id = null;
                        $rombel->save();
                        
                        $guru = Guru::find($guruId);
                        if ($guru) {
                            $guru->rombel_id = null;
                            $guru->save();
                        }
                    }
                }

                // Kosongkan rombel siswa (sudah dilakukan sebelumnya, tapi amankan)
                $siswa->rombel_id = null;
                $siswa->save();

                // Tentukan tahun ajaran
                $tanggalMutasi = $mutasi->tanggal_mutasi ?? Carbon::now();
                $bulan = $tanggalMutasi->month;
                $tahun = $tanggalMutasi->year;
                $tahunAjaran = $bulan >= 7 ? "{$tahun}/" . ($tahun + 1) : ($tahun - 1) . "/{$tahun}";
                $semester = $bulan >= 7 ? 'Ganjil' : 'Genap';

                // Buat alumni
                KenaikanKelas::create([
                    'siswa_id' => $siswa->id,
                    'jurusan_id' => $jurusanId,
                    'kelas_tingkat' => $kelasTingkat,
                    'semester' => $semester,
                    'tahun_ajaran' => $tahunAjaran,
                    'status' => 'Lulus',
                    'catatan' => 'Lulus pada ' . $tanggalMutasi->format('d-m-Y'),
                    'rombel_tujuan_id' => $previousRombelId,
                    'diproses_oleh' => null,
                    'tanggal_diproses' => Carbon::now(),
                ]);

                $this->info("✅ {$siswa->nama_lengkap} (NIS: {$siswa->nis}) - BERHASIL masuk alumni");
                $success++;

            } catch (\Exception $e) {
                $this->error("❌ Gagal: {$siswa->nama_lengkap} - " . $e->getMessage());
                $failed++;
            }
        }

        $this->newLine();
        $this->info("=========================================");
        $this->info("📊 SUMMARY");
        $this->info("=========================================");
        $this->info("Total mutasi LULUS    : " . $mutasiLulus->count());
        $this->info("✅ Berhasil masuk alumni : {$success}");
        $this->info("⏭️  Sudah ada di alumni  : {$skipped}");
        $this->info("❌ Gagal               : {$failed}");
        $this->info("✅ Selesai!");
    }
}