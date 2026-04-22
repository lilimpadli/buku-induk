<?php

namespace App\Imports;

use App\Models\DataSiswa;
use App\Models\User;
use App\Models\Rombel;
use App\Models\Ayah;
use App\Models\Ibu;
use App\Models\Wali;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class SiswaImport implements ToModel, WithHeadingRow, SkipsEmptyRows, SkipsOnError
{
    protected $errors = [];
    protected $successCount = 0;
    protected $defaultPassword = '12345678';
    protected $rowCount = 0;
    protected $skippedEmptyRows = 0;
    protected $processedRows = 0;

    public function model(array $row)
    {
        $this->rowCount++;
        
        // Normalize keys - handle various spellings
        $row = $this->normalizeRow($row);
        
        // Skip empty rows
        if (empty($row['nama_lengkap']) && empty($row['nis']) && empty($row['nisn'])) {
            $this->skippedEmptyRows++;
            return null;
        }

        $this->processedRows++;
        
        try {
            $nis = trim($row['nis'] ?? '');
            $nisn = trim($row['nisn'] ?? '');
            $namaLengkap = trim($row['nama_lengkap'] ?? '');
            
            Log::info("Processing siswa row {$this->rowCount}", [
                'nis' => $nis,
                'nisn' => $nisn,
                'nama' => $namaLengkap
            ]);

            if (empty($namaLengkap)) {
                $this->errors[] = "Baris {$this->rowCount}: Nama lengkap tidak boleh kosong";
                return null;
            }

            // Find existing siswa by NIS (priority) or NISN
            $siswa = null;
            if (!empty($nis)) {
                // NIS is the primary unique identifier (sekolah's student number)
                $siswa = DataSiswa::where('nis', $nis)->first();
            } elseif (!empty($nisn)) {
                // Fall back to NISN if NIS not provided
                $siswa = DataSiswa::where('nisn', $nisn)->first();
            }

            // Find or create user
            $user = null;
            if ($siswa) {
                $user = $siswa->user;
            } else {
                // Try to find user by NIS or NISN
                if (!empty($nis)) {
                    $user = User::where('nomor_induk', $nis)->first();
                }
                if (!$user && !empty($nisn)) {
                    $user = User::where('nomor_induk', $nisn)->first();
                }
            }

            // If no user found, create new user
            if (!$user) {
                $email = trim($row['email'] ?? '');
                
                // Ensure email is unique if provided
                if (!empty($email)) {
                    $existingUser = User::where('email', $email)->first();
                    if ($existingUser) {
                        $this->errors[] = "Baris {$this->rowCount}: Email {$email} sudah terdaftar";
                        return null;
                    }
                }

                try {
                    $user = User::create([
                        'name' => $namaLengkap,
                        'nomor_induk' => $nis ?? $nisn,
                        'email' => !empty($email) ? $email : null,
                        'password' => Hash::make($this->defaultPassword),
                        'role' => 'siswa',
                    ]);
                    
                    Log::info("Created new user", ['user_id' => $user->id, 'name' => $namaLengkap]);
                } catch (\Exception $e) {
                    $this->errors[] = "Baris {$this->rowCount}: Gagal membuat akun - " . $e->getMessage();
                    return null;
                }
            }

            // Prepare data
            $dataSiswaFields = [
                'user_id' => $user->id,
                'nama_lengkap' => $namaLengkap,
                'nis' => $nis ?: null,
                'nisn' => $nisn ?: null,
                'jenis_kelamin' => trim($row['jenis_kelamin'] ?? ''),
                'tempat_lahir' => trim($row['tempat_lahir'] ?? ''),
                'tanggal_lahir' => !empty($row['tanggal_lahir']) ? $this->parseDate($row['tanggal_lahir']) : null,
                'kewarganegaraan' => trim($row['kewarganegaraan'] ?? ''),
                'agama' => trim($row['agama'] ?? ''),
                'rt' => trim($row['rt'] ?? ''),
                'rw' => trim($row['rw'] ?? ''),
                'dusun' => trim($row['dusun'] ?? ''),
                'kelurahan' => trim($row['kelurahan'] ?? ''),
                'kecamatan' => trim($row['kecamatan'] ?? ''),
                'kode_pos' => trim($row['kode_pos'] ?? ''),
                'no_hp' => trim($row['no_hp'] ?? ''),
                'sekolah_asal' => trim($row['sekolah_asal'] ?? ''),
                'tanggal_diterima' => !empty($row['tanggal_diterima']) ? $this->parseDate($row['tanggal_diterima']) : null,
            ];

            // Handle rombel
            if (!empty($row['nama_rombel']) || !empty($row['rombel_id'])) {
                $rombelId = null;
                
                if (!empty($row['rombel_id'])) {
                    $rombelId = $row['rombel_id'];
                } elseif (!empty($row['nama_rombel'])) {
                    $rombel = Rombel::where('nama', trim($row['nama_rombel']))->first();
                    if ($rombel) {
                        $rombelId = $rombel->id;
                    } else {
                        $this->errors[] = "Baris {$this->rowCount}: Rombel '{$row['nama_rombel']}' tidak ditemukan";
                        return null;
                    }
                }
                
                if ($rombelId) {
                    $dataSiswaFields['rombel_id'] = $rombelId;
                }
            }

            // Handle Ayah data
            $namaAyah = trim($row['nama_ayah'] ?? '');
            if (!empty($namaAyah) && $namaAyah !== '-') {
                $ayah = Ayah::firstOrCreate(
                    ['nama' => $namaAyah],
                    [
                        'pekerjaan' => trim($row['pekerjaan_ayah'] ?? ''),
                        'alamat' => trim($row['alamat_rumah'] ?? ''),
                    ]
                );
                $dataSiswaFields['ayah_id'] = $ayah->id;
            }

            // Handle Ibu data
            $namaIbu = trim($row['nama_ibu'] ?? '');
            if (!empty($namaIbu) && $namaIbu !== '-') {
                $ibu = Ibu::firstOrCreate(
                    ['nama' => $namaIbu],
                    [
                        'pekerjaan' => trim($row['pekerjaan_ibu'] ?? ''),
                        'alamat' => trim($row['alamat_rumah'] ?? ''),
                    ]
                );
                $dataSiswaFields['ibu_id'] = $ibu->id;
            }

            // Handle Wali data
            $namaWali = trim($row['nama_wali'] ?? '');
            if (!empty($namaWali) && $namaWali !== '-') {
                $wali = Wali::firstOrCreate(
                    ['nama' => $namaWali],
                    [
                        'pekerjaan' => trim($row['pekerjaan_wali'] ?? ''),
                        'alamat' => trim($row['alamat_wali'] ?? ''),
                    ]
                );
                $dataSiswaFields['wali_id'] = $wali->id;
            }

            // Create or update siswa
            if ($siswa) {
                // When updating, only update fields that have non-empty values
                // This prevents empty import values from overwriting existing data
                $fieldsToUpdate = [];
                foreach ($dataSiswaFields as $key => $value) {
                    // Always update these fields if they have values
                    if ($key === 'nama_lengkap' || $key === 'user_id') {
                        $fieldsToUpdate[$key] = $value;
                    }
                    // For other fields, only update if not empty and not just whitespace
                    elseif (!empty($value) && trim((string)$value) !== '') {
                        $fieldsToUpdate[$key] = $value;
                    }
                }
                
                if (!empty($fieldsToUpdate)) {
                    $siswa->update($fieldsToUpdate);
                }
                Log::info("Updated siswa", ['siswa_id' => $siswa->id, 'updated_fields' => count($fieldsToUpdate)]);
            } else {
                $siswa = DataSiswa::create($dataSiswaFields);
                Log::info("Created siswa", ['siswa_id' => $siswa->id]);
            }

            $this->successCount++;

            return null; // We handle model creation ourselves
        } catch (Throwable $e) {
            $this->errors[] = "Baris {$this->rowCount}: " . $e->getMessage();
            Log::error("Error importing siswa at row {$this->rowCount}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Normalize row keys to handle various column name formats
     */
    protected function normalizeRow(array $row): array
    {
        $normalized = [];
        $keyMap = [
            'nama_lengkap' => ['nama_lengkap', 'nama lengkap', 'nama', 'nama siswa', 'namalengkap'],
            'nis' => ['nis', 'nomor_induk_sekolah', 'no_induk_sekolah'],
            'nisn' => ['nisn', 'nomor_induk_siswa_nasional'],
            'jenis_kelamin' => ['jenis_kelamin', 'jenis kelamin', 'gender', 'jk'],
            'tempat_lahir' => ['tempat_lahir', 'tempat lahir', 'tempat_lahir'],
            'tanggal_lahir' => ['tanggal_lahir', 'tanggal lahir', 'tgl_lahir', 'tgl lahir'],
            'kewarganegaraan' => ['kewarganegaraan', 'kewarganegaraan'],
            'agama' => ['agama', 'agama'],
            'rt' => ['rt', 'r_t'],
            'rw' => ['rw', 'r_w'],
            'dusun' => ['dusun', 'desa', 'dusun_desa'],
            'kelurahan' => ['kelurahan', 'kelurahan', 'desa_kelurahan'],
            'kecamatan' => ['kecamatan', 'kecamatan'],
            'kode_pos' => ['kode_pos', 'kode pos', 'pos', 'kodepos'],
            'no_hp' => ['no_hp', 'no hp', 'nomor_hp', 'nomor hp', 'phone', 'no_telpon'],
            'sekolah_asal' => ['sekolah_asal', 'sekolah asal', 'asal_sekolah', 'asal sekolah'],
            'tanggal_diterima' => ['tanggal_diterima', 'tanggal diterima', 'tgl_diterima', 'mulai_tanggal_diterima', 'mulai tanggal diterima'],
            'email' => ['email', 'email', 'e_mail'],
            'nama_rombel' => ['nama_rombel', 'nama rombel', 'rombel', 'kelas'],
            'rombel_id' => ['rombel_id', 'rombel_id'],
            'nama_ayah' => ['nama_ayah', 'nama ayah'],
            'pekerjaan_ayah' => ['pekerjaan_ayah', 'pekerjaan ayah'],
            'nama_ibu' => ['nama_ibu', 'nama ibu'],
            'pekerjaan_ibu' => ['pekerjaan_ibu', 'pekerjaan ibu'],
            'nama_wali' => ['nama_wali', 'nama wali'],
            'pekerjaan_wali' => ['pekerjaan_wali', 'pekerjaan wali'],
            'alamat_rumah' => ['alamat_rumah', 'alamat rumah', 'alamat'],
            'alamat_wali' => ['alamat_wali', 'alamat wali'],
        ];

        foreach ($row as $key => $value) {
            $normalizedKey = strtolower(str_replace(' ', '_', trim((string)$key)));
            
            $standardKey = $normalizedKey;
            foreach ($keyMap as $standard => $variants) {
                if (in_array($normalizedKey, array_map(function($v) {
                    return strtolower(str_replace(' ', '_', $v));
                }, $variants))) {
                    $standardKey = $standard;
                    break;
                }
            }
            
            $normalized[$standardKey] = $value;
        }

        return $normalized;
    }

    /**
     * Parse date from various formats
     */
    protected function parseDate($dateValue)
    {
        if (empty($dateValue)) {
            return null;
        }

        try {
            // If it's a timestamp (Excel serial number), convert it
            if (is_numeric($dateValue)) {
                $dateValue = \DateTime::createFromFormat('U', intval(($dateValue - 25569) * 86400))->format('Y-m-d');
            }

            return \Carbon\Carbon::createFromFormat('Y-m-d', $dateValue)?->format('Y-m-d') 
                ?? \Carbon\Carbon::createFromFormat('d-m-Y', $dateValue)?->format('Y-m-d')
                ?? \Carbon\Carbon::parse($dateValue)?->format('Y-m-d');
        } catch (\Exception $e) {
            Log::warning("Could not parse date: {$dateValue}", ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }
    
    public function getSkippedEmptyRows()
    {
        return $this->skippedEmptyRows;
    }
    
    public function getProcessedRows()
    {
        return $this->processedRows;
    }
    
    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function onError(Throwable $e)
    {
        Log::error('SiswaImport error', [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ]);
        $this->errors[] = "Error teknis: " . $e->getMessage();
    }
}
