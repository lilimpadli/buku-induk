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

    // ==================================================================
    // HELPER UMUM
    // ==================================================================

    private function upper($value)
    {
        if ($value === null || $value === '') return null;
        return strtoupper(trim($value));
    }

    private function titleCase($value)
    {
        if ($value === null || $value === '') return null;
        return ucwords(strtolower(trim($value)));
    }

    private function cleanStr($value)
    {
        if ($value === null) return null;
        $value = trim((string) $value);
        if ($value === '' || $value === '-' || $value === '0') return null;
        return $value;
    }

    private function cleanInt($value)
    {
        if ($value === null || $value === '') return null;
        if (is_numeric($value)) return (int) $value;
        $value = preg_replace('/[^0-9-]/', '', (string) $value);
        return $value === '' ? null : (int) $value;
    }

    private function cleanDecimal($value)
    {
        if ($value === null || $value === '') return null;
        if (is_numeric($value)) return (float) $value;
        $value = str_replace(',', '.', (string) $value);
        $value = preg_replace('/[^0-9.\-]/', '', $value);
        if ($value === '' || $value === '.' || $value === '-') return null;
        return (float) $value;
    }

    // ==================================================================
    // EXTRACT DAPODIK
    // ==================================================================

    private function extractDapodikFields(array $row): array
    {
        return [
            // A. Identitas
            'nik'                 => $this->cleanStr($row['nik'] ?? null),
            'no_kk'               => $this->cleanStr($row['no_kk'] ?? null),
            'no_registrasi_akta'  => $this->cleanStr($row['no_registrasi_akta_lahir'] ?? $row['no_registrasi_akta'] ?? null),
            'kebutuhan_khusus'    => $this->cleanStr($row['kebutuhan_khusus'] ?? null),
            'alat_transportasi'   => $this->cleanStr($row['alat_transportasi'] ?? null),
            'jenis_tinggal'       => $this->cleanStr($row['jenis_tinggal'] ?? null),
            'email'               => $this->cleanStr($row['e_mail'] ?? $row['email'] ?? null),

            // B. Ayah
            'tahun_lahir_ayah'         => $this->cleanInt($row['tahun_lahir_ayah'] ?? null),
            'jenjang_pendidikan_ayah'  => $this->cleanStr($row['jenjang_pendidikan_ayah'] ?? null),
            'penghasilan_ayah'         => $this->cleanStr($row['penghasilan_ayah'] ?? null),
            'nik_ayah'                 => $this->cleanStr($row['nik_ayah'] ?? null),

            // C. Ibu
            'tahun_lahir_ibu'          => $this->cleanInt($row['tahun_lahir_ibu'] ?? null),
            'jenjang_pendidikan_ibu'   => $this->cleanStr($row['jenjang_pendidikan_ibu'] ?? null),
            'penghasilan_ibu'          => $this->cleanStr($row['penghasilan_ibu'] ?? null),
            'nik_ibu'                  => $this->cleanStr($row['nik_ibu'] ?? null),

            // D. Wali
            'tahun_lahir_wali'         => $this->cleanInt($row['tahun_lahir_wali'] ?? null),
            'jenjang_pendidikan_wali'  => $this->cleanStr($row['jenjang_pendidikan_wali'] ?? null),
            'penghasilan_wali'         => $this->cleanStr($row['penghasilan_wali'] ?? null),
            'nik_wali'                 => $this->cleanStr($row['nik_wali'] ?? null),

            // E. KIP/KPS
            'penerima_kps'   => $this->cleanStr($row['penerima_kps'] ?? null),
            'no_kps'         => $this->cleanStr($row['no_kps'] ?? null),
            'penerima_kip'   => $this->cleanStr($row['penerima_kip'] ?? null),
            'nomor_kip'      => $this->cleanStr($row['nomor_kip'] ?? null),
            'nama_kip'       => $this->cleanStr($row['nama_di_kip'] ?? $row['nama_kip'] ?? null),
            'nomor_kks'      => $this->cleanStr($row['nomor_kks'] ?? null),

            // F. Bank & PIP
            'bank'                => $this->cleanStr($row['bank'] ?? null),
            'nomor_rekening'      => $this->cleanStr($row['nomor_rekening_bank'] ?? $row['nomor_rekening'] ?? null),
            'rekening_atas_nama'  => $this->cleanStr($row['rekening_atas_nama'] ?? null),
            'layak_pip'           => $this->cleanStr($row['layak_pip_usulan_dari_sekolah'] ?? $row['layak_pip'] ?? null),
            'alasan_layak_pip'    => $this->cleanStr($row['alasan_layak_pip'] ?? null),

            // G. Ujian
            'skhun'             => $this->cleanStr($row['skhun'] ?? null),
            'no_peserta_un'     => $this->cleanStr($row['no_peserta_ujian_nasional'] ?? $row['no_peserta_un'] ?? null),
            'no_seri_ijazah'    => $this->cleanStr($row['no_seri_ijazah'] ?? null),

            // H. Fisik & lokasi
            'berat_badan'           => $this->cleanDecimal($row['berat_badan'] ?? null),
            'tinggi_badan'          => $this->cleanDecimal($row['tinggi_badan'] ?? null),
            'lingkar_kepala'        => $this->cleanDecimal($row['lingkar_kepala'] ?? null),
            'jumlah_saudara'        => $this->cleanInt($row['jml_saudara_kandung'] ?? $row['jumlah_saudara'] ?? null),
            'jarak_rumah_sekolah'   => $this->cleanDecimal($row['jarak_rumah_ke_sekolah_km'] ?? $row['jarak_rumah_sekolah'] ?? null),
            'lintang'               => $this->cleanDecimal($row['lintang'] ?? null),
            'bujur'                 => $this->cleanDecimal($row['bujur'] ?? null),
        ];
    }

    // ==================================================================
    // MAIN: model()
    // ==================================================================

    public function model(array $row)
    {
        $this->rowCount++;
        $this->processedRows++;

        try {
            // Normalize row keys
            $normalizedRow = [];
            foreach ($row as $key => $value) {
                $normalizedRow[strtolower(trim($key))] = $value;
            }
            $row = $normalizedRow;

            $nis = $row['nis'] ?? null;
            $nisn = $row['nisn'] ?? null;
            $nama = $row['nama_lengkap'] ?? $row['nama'] ?? null;

            if (empty($nis)) {
                $this->skippedEmptyRows++;
                Log::warning("SiswaImport: Baris {$this->rowCount} - NIS kosong, dilewati");
                return null;
            }

            // Cek duplikat di data_siswa
            $existingSiswa = DataSiswa::where('nis', $nis)->first();
            if ($existingSiswa) {
                $this->updateExistingSiswa($existingSiswa, $row);
                $this->updatedCount++;
                $this->successCount++;
                Log::info("SiswaImport: NIS {$nis} sudah ada, diUPDATE");
                return null;
            }

            // Cek duplikat di users
            $existingUser = User::where('nomor_induk', $nis)->first();
            if ($existingUser) {
                $existingUser->delete();
                Log::info("SiswaImport: User dengan NIS {$nis} dihapus (akan dibuat ulang)");
            }

            return $this->createNewSiswa($row);

        } catch (\Exception $e) {
            Log::error("SiswaImport: Error baris {$this->rowCount}: " . $e->getMessage());
            $this->errors[] = "Baris {$this->rowCount}: " . $e->getMessage();
            return null;
        }
    }

    // ==================================================================
    // UPDATE
    // ==================================================================

    private function updateExistingSiswa($siswa, $row)
    {
        $agamaId = $this->resolveAgama($row);
        $jenisKelaminId = $this->resolveJenisKelamin($row);
        $rombelId = $this->resolveRombel($row);

        $tanggalLahir = $this->parseDate($row['tanggal_lahir'] ?? null);
        $tanggalDiterima = $this->parseDate($row['mulai_tanggal_diterima'] ?? $row['tanggal_diterima'] ?? null);

        $dapodikFields = $this->extractDapodikFields($row);

        $siswa->update(array_merge([
            'nama_lengkap' => $this->upper($row['nama_lengkap'] ?? $row['nama'] ?? null) ?? $siswa->nama_lengkap,
            'nisn' => $row['nisn'] ?? $siswa->nisn,
            'jenis_kelamin_id' => $jenisKelaminId ?? $siswa->jenis_kelamin_id,
            'agama_id' => $agamaId ?? $siswa->agama_id,
            'tempat_lahir' => $this->upper($row['tempat_lahir'] ?? null) ?? $siswa->tempat_lahir,
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

            'nama_ayah' => $this->upper($row['nama_ayah'] ?? null) ?? $siswa->nama_ayah,
            'pekerjaan_ayah' => $this->upper($row['pekerjaan_ayah'] ?? null) ?? $siswa->pekerjaan_ayah,
            'telepon_ayah' => $row['telepon_ayah'] ?? $row['no_hp_ayah'] ?? $siswa->telepon_ayah,

            'nama_ibu' => $this->upper($row['nama_ibu'] ?? null) ?? $siswa->nama_ibu,
            'pekerjaan_ibu' => $this->upper($row['pekerjaan_ibu'] ?? null) ?? $siswa->pekerjaan_ibu,
            'telepon_ibu' => $row['telepon_ibu'] ?? $row['no_hp_ibu'] ?? $siswa->telepon_ibu,

            'nama_wali' => $this->upper($row['nama_wali'] ?? null) ?? $siswa->nama_wali,
            'pekerjaan_wali' => $this->upper($row['pekerjaan_wali'] ?? null) ?? $siswa->pekerjaan_wali,
            'telepon_wali' => $row['telepon_wali'] ?? $row['no_hp_wali'] ?? $siswa->telepon_wali,
            'alamat_wali' => $row['alamat_wali'] ?? $siswa->alamat_wali,
        ], $dapodikFields));

        if ($siswa->user) {
            $siswa->user->update([
                'name' => $this->upper($row['nama_lengkap'] ?? $row['nama'] ?? null) ?? $siswa->nama_lengkap,
                'nomor_induk' => $row['nis'] ?? $siswa->nis,
            ]);
        }
    }

    // ==================================================================
    // CREATE
    // ==================================================================

    private function createNewSiswa($row)
    {
        $nis = $row['nis'] ?? null;
        $nama = $this->upper($row['nama_lengkap'] ?? $row['nama'] ?? null);

        $agamaId = $this->resolveAgama($row);
        $jenisKelaminId = $this->resolveJenisKelamin($row);
        $rombelId = $this->resolveRombel($row);

        $tanggalLahir = $this->parseDate($row['tanggal_lahir'] ?? null);
        $tanggalDiterima = $this->parseDate($row['mulai_tanggal_diterima'] ?? $row['tanggal_diterima'] ?? null);

        $user = User::create([
            'name' => $nama,
            'email' => $nis . '@siswa.local',
            'password' => Hash::make($nis . '123'),
            'role' => 'siswa',
            'nomor_induk' => $nis,
        ]);

        $dapodikFields = $this->extractDapodikFields($row);

        $siswa = DataSiswa::create(array_merge([
            'user_id' => $user->id,
            'nama_lengkap' => $nama,
            'nis' => $nis,
            'nisn' => $row['nisn'] ?? null,
            'jenis_kelamin_id' => $jenisKelaminId,
            'agama_id' => $agamaId,
            'agama_lainnya' => null,
            'tempat_lahir' => $this->upper($row['tempat_lahir'] ?? null),
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

            'nama_ayah' => $this->upper($row['nama_ayah'] ?? null),
            'pekerjaan_ayah' => $this->upper($row['pekerjaan_ayah'] ?? null),
            'telepon_ayah' => $row['telepon_ayah'] ?? $row['no_hp_ayah'] ?? null,

            'nama_ibu' => $this->upper($row['nama_ibu'] ?? null),
            'pekerjaan_ibu' => $this->upper($row['pekerjaan_ibu'] ?? null),
            'telepon_ibu' => $row['telepon_ibu'] ?? $row['no_hp_ibu'] ?? null,

            'nama_wali' => $this->upper($row['nama_wali'] ?? null),
            'pekerjaan_wali' => $this->upper($row['pekerjaan_wali'] ?? null),
            'telepon_wali' => $row['telepon_wali'] ?? $row['no_hp_wali'] ?? null,
            'alamat_wali' => $row['alamat_wali'] ?? null,
        ], $dapodikFields));

        $this->successCount++;
        Log::info("SiswaImport: Berhasil import NIS {$nis} - {$nama}");

        return $siswa;
    }

    // ==================================================================
    // RESOLVE HELPERS
    // ==================================================================

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

    private function resolveJenisKelamin($row)
    {
        $jk = trim($row['jenis_kelamin'] ?? '');
        if (empty($jk)) return null;

        $jkMap = [
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
            'Laki-laki' => 'Laki-laki',
            'Perempuan' => 'Perempuan',
        ];
        $jkNama = $jkMap[$jk] ?? $jk;
        $jenisKelamin = JenisKelamin::where('nama', 'like', $jkNama)->first();

        if (!$jenisKelamin) {
            Log::warning("SiswaImport: Jenis Kelamin '{$jk}' tidak ditemukan");
            return null;
        }
        return $jenisKelamin->id;
    }

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

    // ==================================================================
    // CONTROLLERS INTERFACE
    // ==================================================================

    public function chunkSize(): int
    {
        return 100;
    }

    public function onError(\Throwable $e)
    {
        Log::error('SiswaImport Error: ' . $e->getMessage());
    }

    public function getSuccessCount() { return $this->successCount; }
    public function getUpdatedCount() { return $this->updatedCount; }
    public function getErrors() { return $this->errors; }
    public function getProcessedRows() { return $this->processedRows; }
    public function getRowCount() { return $this->rowCount; }
    public function getSkippedEmptyRows() { return $this->skippedEmptyRows; }

    // ==================================================================
    // DATE PARSER
    // ==================================================================

    private function parseDate($date)
    {
        if (empty($date)) return null;

        $date = trim($date);

        if (is_numeric($date)) {
            return date('Y-m-d', strtotime('1899-12-30 + ' . ((int)$date) . ' days'));
        }

        if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/', $date, $matches)) {
            return "{$matches[3]}-{$matches[2]}-{$matches[1]}";
        }

        if (preg_match('/^(\d{4})[\/\-](\d{1,2})[\/\-](\d{1,2})$/', $date, $matches)) {
            return "{$matches[1]}-{$matches[2]}-{$matches[3]}";
        }

        try {
            return date('Y-m-d', strtotime($date));
        } catch (\Exception $e) {
            Log::warning("SiswaImport: Gagal parse tanggal: {$date}");
            return null;
        }
    }
}