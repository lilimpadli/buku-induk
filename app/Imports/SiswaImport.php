<?php

namespace App\Imports;

use App\Models\DataSiswa;
use App\Models\User;
use App\Models\Rombel;
use App\Models\Agama;
use App\Models\JenisKelamin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SiswaImport implements ToModel, WithHeadingRow, WithChunkReading, SkipsOnError, SkipsEmptyRows
{
    protected $successCount = 0;
    protected $errors = [];
    protected $processedRows = 0;
    protected $rowCount = 0;
    protected $skippedEmptyRows = 0;
    protected $updatedCount = 0;

    public function model(array $row)
    {
        $this->rowCount++;
        $this->processedRows++;

        try {
            // Normalize row keys (case-insensitive)
            $normalizedRow = [];
            foreach ($row as $key => $value) {
                $normalizedRow[strtolower(trim($key))] = $value;
            }
            $row = $normalizedRow;

            // Ambil data dengan default null
            $nis = $row['nis'] ?? null;
            $nisn = $row['nisn'] ?? null;
            $nama = $row['nama_lengkap'] ?? $row['nama'] ?? null;

            // Skip jika NIS kosong
            if (empty($nis)) {
                $this->skippedEmptyRows++;
                Log::warning("SiswaImport: Baris {$this->rowCount} - NIS kosong, dilewati");
                return null;
            }

            // ============================================================
            // CEK DUPLIKAT NIS DI data_siswa
            // ============================================================
            $existingSiswa = DataSiswa::where('nis', $nis)->first();
            if ($existingSiswa) {
                // UPDATE data yang sudah ada
                $this->updateExistingSiswa($existingSiswa, $row);
                $this->updatedCount++;
                $this->successCount++;
                Log::info("SiswaImport: NIS {$nis} sudah ada, diUPDATE");
                return null;
            }

            // ============================================================
            // CEK DUPLIKAT NIS DI users
            // ============================================================
            $existingUser = User::where('nomor_induk', $nis)->first();
            if ($existingUser) {
                // Hapus user yang sudah ada (karena akan dibuat ulang)
                $existingUser->delete();
                Log::info("SiswaImport: User dengan NIS {$nis} dihapus (akan dibuat ulang)");
            }

            // ============================================================
            // CREATE SISWA BARU
            // ============================================================
            return $this->createNewSiswa($row);

        } catch (\Exception $e) {
            Log::error("SiswaImport: Error baris {$this->rowCount}: " . $e->getMessage());
            $this->errors[] = "Baris {$this->rowCount}: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Update data siswa yang sudah ada
     */
    private function updateExistingSiswa($siswa, $row)
    {
        // Resolve data
        $agamaId = $this->resolveAgama($row);
        $jenisKelaminId = $this->resolveJenisKelamin($row);
        $rombelId = $this->resolveRombel($row);
        
        $tanggalLahir = $this->parseDate($row['tanggal_lahir'] ?? null);
        $tanggalDiterima = $this->parseDate($row['mulai_tanggal_diterima'] ?? $row['tanggal_diterima'] ?? null);

        $siswa->update([
            'nama_lengkap' => $row['nama_lengkap'] ?? $row['nama'] ?? $siswa->nama_lengkap,
            'nisn' => $row['nisn'] ?? $siswa->nisn,
            'jenis_kelamin_id' => $jenisKelaminId ?? $siswa->jenis_kelamin_id,
            'agama_id' => $agamaId ?? $siswa->agama_id,
            'tempat_lahir' => $row['tempat_lahir'] ?? $siswa->tempat_lahir,
            'tanggal_lahir' => $tanggalLahir ?? $siswa->tanggal_lahir,
            'kewarganegaraan' => $row['kewarganegaraan'] ?? $siswa->kewarganegaraan ?? 'Indonesia',
            'rt' => $row['rt'] ?? $siswa->rt,
            'rw' => $row['rw'] ?? $siswa->rw,
            'dusun' => $row['dusun'] ?? $siswa->dusun,
            'kelurahan' => $row['kelurahan'] ?? $siswa->kelurahan,
            'kecamatan' => $row['kecamatan'] ?? $siswa->kecamatan,
            'kode_pos' => $row['kode_pos'] ?? $siswa->kode_pos,
            'no_hp' => $row['no_hp'] ?? $siswa->no_hp,
            'sekolah_asal' => $row['asal_sekolah'] ?? $row['sekolah_asal'] ?? $siswa->sekolah_asal,
            'tanggal_diterima' => $tanggalDiterima ?? $siswa->tanggal_diterima,
            'rombel_id' => $rombelId ?? $siswa->rombel_id,
            
            // ============================================================
            // DATA AYAH
            // ============================================================
            'nama_ayah' => $row['nama_ayah'] ?? $siswa->nama_ayah,
            'pekerjaan_ayah' => $row['pekerjaan_ayah'] ?? $siswa->pekerjaan_ayah,
            'telepon_ayah' => $row['telepon_ayah'] ?? $row['no_hp_ayah'] ?? $siswa->telepon_ayah,
            
            // ============================================================
            // DATA IBU
            // ============================================================
            'nama_ibu' => $row['nama_ibu'] ?? $siswa->nama_ibu,
            'pekerjaan_ibu' => $row['pekerjaan_ibu'] ?? $siswa->pekerjaan_ibu,
            'telepon_ibu' => $row['telepon_ibu'] ?? $row['no_hp_ibu'] ?? $siswa->telepon_ibu,
            
            // ============================================================
            // DATA WALI
            // ============================================================
            'nama_wali' => $row['nama_wali'] ?? $siswa->nama_wali,
            'pekerjaan_wali' => $row['pekerjaan_wali'] ?? $siswa->pekerjaan_wali,
            'telepon_wali' => $row['telepon_wali'] ?? $row['no_hp_wali'] ?? $siswa->telepon_wali,
            'alamat_wali' => $row['alamat_wali'] ?? $siswa->alamat_wali,
        ]);

        // Update user jika ada
        if ($siswa->user) {
            $siswa->user->update([
                'name' => $row['nama_lengkap'] ?? $row['nama'] ?? $siswa->nama_lengkap,
                'nomor_induk' => $row['nis'] ?? $siswa->nis,
            ]);
        }
    }

    /**
     * Create siswa baru
     */
    private function createNewSiswa($row)
    {
        $nis = $row['nis'] ?? null;
        $nama = $row['nama_lengkap'] ?? $row['nama'] ?? null;

        // Resolve data
        $agamaId = $this->resolveAgama($row);
        $jenisKelaminId = $this->resolveJenisKelamin($row);
        $rombelId = $this->resolveRombel($row);
        
        $tanggalLahir = $this->parseDate($row['tanggal_lahir'] ?? null);
        $tanggalDiterima = $this->parseDate($row['mulai_tanggal_diterima'] ?? $row['tanggal_diterima'] ?? null);

        // Buat user
        $user = User::create([
            'name' => $nama,
            'email' => $nis . '@siswa.local',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
            'nomor_induk' => $nis,
        ]);

        // Buat data siswa
        $siswa = DataSiswa::create([
            'user_id' => $user->id,
            'nama_lengkap' => $nama,
            'nis' => $nis,
            'nisn' => $row['nisn'] ?? null,
            'jenis_kelamin_id' => $jenisKelaminId,
            'agama_id' => $agamaId,
            'agama_lainnya' => null,
            'tempat_lahir' => $row['tempat_lahir'] ?? null,
            'tanggal_lahir' => $tanggalLahir,
            'kewarganegaraan' => $row['kewarganegaraan'] ?? 'Indonesia',
            'rt' => $row['rt'] ?? null,
            'rw' => $row['rw'] ?? null,
            'dusun' => $row['dusun'] ?? null,
            'kelurahan' => $row['kelurahan'] ?? null,
            'kecamatan' => $row['kecamatan'] ?? null,
            'kode_pos' => $row['kode_pos'] ?? null,
            'no_hp' => $row['no_hp'] ?? null,
            'sekolah_asal' => $row['asal_sekolah'] ?? $row['sekolah_asal'] ?? null,
            'tanggal_diterima' => $tanggalDiterima,
            'rombel_id' => $rombelId,
            
            // ============================================================
            // DATA AYAH
            // ============================================================
            'nama_ayah' => $row['nama_ayah'] ?? null,
            'pekerjaan_ayah' => $row['pekerjaan_ayah'] ?? null,
            'telepon_ayah' => $row['telepon_ayah'] ?? $row['no_hp_ayah'] ?? null,
            
            // ============================================================
            // DATA IBU
            // ============================================================
            'nama_ibu' => $row['nama_ibu'] ?? null,
            'pekerjaan_ibu' => $row['pekerjaan_ibu'] ?? null,
            'telepon_ibu' => $row['telepon_ibu'] ?? $row['no_hp_ibu'] ?? null,
            
            // ============================================================
            // DATA WALI
            // ============================================================
            'nama_wali' => $row['nama_wali'] ?? null,
            'pekerjaan_wali' => $row['pekerjaan_wali'] ?? null,
            'telepon_wali' => $row['telepon_wali'] ?? $row['no_hp_wali'] ?? null,
            'alamat_wali' => $row['alamat_wali'] ?? null,
        ]);

        $this->successCount++;
        Log::info("SiswaImport: Berhasil import NIS {$nis} - {$nama}");

        return $siswa;
    }

    /**
     * Resolve agama
     */
    private function resolveAgama($row)
    {
        $agamaNama = trim($row['agama'] ?? '');
        if (empty($agamaNama)) return null;
        
        $agama = Agama::where('nama', 'like', $agamaNama)->first();
        if (!$agama) {
            Log::warning("SiswaImport: Agama '{$agamaNama}' tidak ditemukan");
            return null;
        }
        return $agama->id;
    }

    /**
     * Resolve jenis kelamin
     */
    private function resolveJenisKelamin($row)
    {
        $jk = trim($row['jenis_kelamin'] ?? '');
        if (empty($jk)) return null;
        
        $jkMap = ['L' => 'Laki-laki', 'P' => 'Perempuan', 'Laki-laki' => 'Laki-laki', 'Perempuan' => 'Perempuan'];
        $jkNama = $jkMap[$jk] ?? $jk;
        $jenisKelamin = JenisKelamin::where('nama', 'like', $jkNama)->first();
        
        if (!$jenisKelamin) {
            Log::warning("SiswaImport: Jenis Kelamin '{$jk}' tidak ditemukan");
            return null;
        }
        return $jenisKelamin->id;
    }

    /**
     * Resolve rombel
     */
    private function resolveRombel($row)
    {
        $rombelNama = trim($row['nama_rombel'] ?? $row['rombel'] ?? '');
        if (empty($rombelNama)) return null;
        
        $rombel = Rombel::where('nama', 'like', $rombelNama)->first();
        if (!$rombel) {
            Log::warning("SiswaImport: Rombel '{$rombelNama}' tidak ditemukan");
            return null;
        }
        return $rombel->id;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function onError(\Throwable $e)
    {
        Log::error('SiswaImport Error: ' . $e->getMessage());
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getUpdatedCount()
    {
        return $this->updatedCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getProcessedRows()
    {
        return $this->processedRows;
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function getSkippedEmptyRows()
    {
        return $this->skippedEmptyRows;
    }

    private function parseDate($date)
    {
        if (empty($date)) return null;

        $date = trim($date);

        // Excel serial number
        if (is_numeric($date)) {
            return date('Y-m-d', strtotime('1899-12-30 + ' . ((int)$date) . ' days'));
        }

        // Format DD/MM/YYYY atau DD-MM-YYYY
        if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/', $date, $matches)) {
            return "{$matches[3]}-{$matches[2]}-{$matches[1]}";
        }

        // Format YYYY-MM-DD
        if (preg_match('/^(\d{4})[\/\-](\d{1,2})[\/\-](\d{1,2})$/', $date, $matches)) {
            return "{$matches[1]}-{$matches[2]}-{$matches[3]}";
        }

        // Fallback ke Carbon
        try {
            return date('Y-m-d', strtotime($date));
        } catch (\Exception $e) {
            Log::warning("SiswaImport: Gagal parse tanggal: {$date}");
            return null;
        }
    }
}