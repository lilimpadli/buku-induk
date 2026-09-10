<?php

namespace App\Observers;

use App\Models\KenaikanKelas;
use App\Models\MutasiSiswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MutasiSiswaObserver
{
    public function created(MutasiSiswa $mutasi): void
    {
        Log::info("🔔 OBSERVER created: Mutasi ID {$mutasi->id}, Status: {$mutasi->status}");

        if ($mutasi->status === 'lulus') {
            $this->prosesLulus($mutasi);
        } elseif ($mutasi->status === 'naik_kelas') {
            if (method_exists($mutasi, 'handleNaikKelas')) {
                $mutasi->handleNaikKelas();
            }
        }
    }

    public function updated(MutasiSiswa $mutasi): void
    {
        if ($mutasi->isDirty('status')) {
            Log::info("🔔 OBSERVER updated: Mutasi ID {$mutasi->id}, Status baru: {$mutasi->status}");

            if ($mutasi->status === 'lulus') {
                $this->prosesLulus($mutasi);
            } elseif ($mutasi->status === 'naik_kelas') {
                if (method_exists($mutasi, 'handleNaikKelas')) {
                    $mutasi->handleNaikKelas();
                }
            }
        }
    }

    private function prosesLulus(MutasiSiswa $mutasi)
    {
        $siswa = $mutasi->siswa;
        if (!$siswa) {
            Log::error("❌ Siswa tidak ditemukan untuk mutasi ID: {$mutasi->id}");
            return;
        }

        Log::info("📌 Memproses kelulusan: {$siswa->nama_lengkap} (NIS: {$siswa->nis})");

        // Cek apakah sudah ada di alumni
        $exists = KenaikanKelas::where('siswa_id', $siswa->id)
            ->where('status', 'Lulus')
            ->exists();

        if ($exists) {
            Log::info("⏭️ Siswa {$siswa->nama_lengkap} sudah ada di alumni, dilewati");
            return;
        }

        // ============================================================
        // 🔥 FIX 1: Ambil data SEBELUM rombel_id di-null kan
        // ============================================================
        $jurusanId = null;
        $kelasTingkat = null;
        $previousRombelId = $siswa->rombel_id;
        $tahunAjaran = null;

        // 1. Ambil dari relasi rombel siswa
        if ($siswa->rombel && $siswa->rombel->kelas) {
            $jurusanId = $siswa->rombel->kelas->jurusan_id;
            $kelasTingkat = $siswa->rombel->kelas->tingkat;
            $tahunAjaran = $siswa->rombel->tahun_ajaran ?? null;
            Log::info("📌 Data jurusan dari rombel: jurusan_id={$jurusanId}, tingkat={$kelasTingkat}");
        }

        // 2. Fallback: Ambil dari rombel_asal_id di mutasi
        if (!$jurusanId && $mutasi->rombel_asal_id) {
            $rombelAsal = \App\Models\Rombel::with('kelas')->find($mutasi->rombel_asal_id);
            if ($rombelAsal && $rombelAsal->kelas) {
                $jurusanId = $rombelAsal->kelas->jurusan_id;
                $kelasTingkat = $rombelAsal->kelas->tingkat;
                $tahunAjaran = $rombelAsal->tahun_ajaran ?? null;
                Log::info("📌 Data jurusan dari rombel_asal: jurusan_id={$jurusanId}, tingkat={$kelasTingkat}");
            }
        }

        // 3. Fallback: Ambil dari kelas_id siswa
        if (!$jurusanId && $siswa->kelas_id) {
            $kelas = \App\Models\Kelas::with('jurusan')->find($siswa->kelas_id);
            if ($kelas && $kelas->jurusan) {
                $jurusanId = $kelas->jurusan_id;
                $kelasTingkat = $kelas->tingkat;
                Log::info("📌 Data jurusan dari kelas_id: jurusan_id={$jurusanId}, tingkat={$kelasTingkat}");
            }
        }

        // 4. Fallback terakhir: Cari dari data siswa lain di rombel yang sama (jika ada)
        if (!$jurusanId && $previousRombelId) {
            $siswaLain = \App\Models\Siswa::where('rombel_id', $previousRombelId)
                ->where('id', '!=', $siswa->id)
                ->with('rombel.kelas')
                ->first();
            if ($siswaLain && $siswaLain->rombel && $siswaLain->rombel->kelas) {
                $jurusanId = $siswaLain->rombel->kelas->jurusan_id;
                $kelasTingkat = $siswaLain->rombel->kelas->tingkat;
                Log::info("📌 Data jurusan dari siswa lain di rombel yang sama: jurusan_id={$jurusanId}");
            }
        }

        // Log peringatan jika jurusan_id masih null
        if (!$jurusanId) {
            Log::warning("⚠️ JURUSAN_ID TIDAK DITEMUKAN untuk siswa {$siswa->nama_lengkap} (ID: {$siswa->id})");
        }

        // ============================================================
        // 🔥 FIX 2: SEKARANG baru kosongkan rombel_id siswa
        // ============================================================
        $siswa->rombel_id = null;
        if (array_key_exists('kelas_id', $siswa->getAttributes())) {
            $siswa->kelas_id = null;
        }
        $siswa->save();

        Log::info("✅ ROMBEL DIKOSONGKAN: siswa {$siswa->nama_lengkap} (ID: {$siswa->id})");

        // ============================================================
        // 🔥 FIX 3: Tentukan tahun ajaran dan semester
        // ============================================================
        $tanggalMutasi = $mutasi->tanggal_mutasi ?? Carbon::now();
        $bulan = $tanggalMutasi->month;
        $tahun = $tanggalMutasi->year;
        
        // Gunakan tahun ajaran dari rombel jika ada, atau hitung otomatis
        if (!$tahunAjaran) {
            $tahunAjaran = $bulan >= 7 ? "{$tahun}/" . ($tahun + 1) : ($tahun - 1) . "/{$tahun}";
        }
        
        $semester = $bulan >= 7 ? 'Ganjil' : 'Genap';

        // ============================================================
        // 🔥 FIX 4: Penanganan diproses_oleh yang aman
        // ============================================================
        $userId = $mutasi->diproses_oleh ?? auth()->id();
        if (!$userId) {
            $firstUser = User::first();
            $userId = $firstUser ? $firstUser->id : 1; // Default ke 1 jika tidak ada user
        }

        // ============================================================
        // 🔥 FIX 5: Simpan ke alumni DENGAN VALIDASI
        // ============================================================
        try {
            $alumniData = [
                'siswa_id' => $siswa->id,
                'jurusan_id' => $jurusanId, // BISA NULL, tapi akan di-fix oleh controller
                'kelas_tingkat' => $kelasTingkat ?? 'XII',
                'semester' => $semester,
                'tahun_ajaran' => $tahunAjaran,
                'status' => 'Lulus',
                'catatan' => $mutasi->keterangan ?? 'Lulus pada ' . $tanggalMutasi->format('d-m-Y'),
                'rombel_tujuan_id' => $previousRombelId,
                'diproses_oleh' => $userId,
                'tanggal_diproses' => Carbon::now(),
            ];

            // Log data yang akan disimpan
            Log::info("📝 Data alumni akan disimpan:", $alumniData);

            $alumni = KenaikanKelas::create($alumniData);

            Log::info("✅ SISWA LULUS: {$siswa->nama_lengkap} (NIS: {$siswa->nis}) - Alumni ID: {$alumni->id}, Jurusan ID: {$jurusanId}");

            // 🔥 FIX 6: Jika jurusan_id null, update dengan data dari sumber lain
            if (!$jurusanId) {
                $this->fixJurusanIdAfterCreate($alumni, $siswa, $previousRombelId);
            }

        } catch (\Exception $e) {
            Log::error("❌ Gagal membuat alumni: " . $e->getMessage(), [
                'siswa_id' => $siswa->id,
                'jurusan_id' => $jurusanId,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * 🔥 FIX 6: Perbaikan jurusan_id setelah create jika masih null
     */
    private function fixJurusanIdAfterCreate($alumni, $siswa, $rombelId)
    {
        try {
            $jurusanId = null;

            // Coba cari dari rombel yang sama (data history)
            if ($rombelId) {
                $rombel = \App\Models\Rombel::with('kelas')->find($rombelId);
                if ($rombel && $rombel->kelas) {
                    $jurusanId = $rombel->kelas->jurusan_id;
                }
            }

            // Coba cari dari data siswa lain dengan nama yang mirip
            if (!$jurusanId && $siswa->nama_lengkap) {
                $namaParts = explode(' ', $siswa->nama_lengkap);
                $firstName = $namaParts[0] ?? '';
                
                $siswaLain = \App\Models\Siswa::where('nama_lengkap', 'like', "%{$firstName}%")
                    ->where('id', '!=', $siswa->id)
                    ->whereNotNull('rombel_id')
                    ->with('rombel.kelas')
                    ->first();
                    
                if ($siswaLain && $siswaLain->rombel && $siswaLain->rombel->kelas) {
                    $jurusanId = $siswaLain->rombel->kelas->jurusan_id;
                }
            }

            if ($jurusanId) {
                $alumni->jurusan_id = $jurusanId;
                $alumni->save();
                Log::info("✅ JURUSAN_ID DI-FIX: Alumni ID {$alumni->id} sekarang jurusan_id={$jurusanId}");
            } else {
                Log::warning("⚠️ TIDAK BISA FIX JURUSAN_ID untuk alumni ID {$alumni->id}");
            }
        } catch (\Exception $e) {
            Log::error("❌ Gagal fix jurusan_id: " . $e->getMessage());
        }
    }
}