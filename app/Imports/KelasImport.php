<?php

namespace App\Imports;

use App\Models\Rombel;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Guru;
use App\Models\KonsentrasiKeahlian;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KelasImport implements ToModel, WithHeadingRow, WithValidation
{
    private $errors = [];
    private $successCount = 0;
    private $processedRows = 0;
    private $updatedCount = 0;
    private $createdCount = 0;

    public function model(array $row)
    {
        $this->processedRows++;

        try {
            DB::beginTransaction();

            // 1. Cari Jurusan
            $jurusan = Jurusan::where('kode', $row['jurusan_kode'])->first();
            if (!$jurusan) {
                // Coba cari berdasarkan nama (fallback)
                $jurusan = Jurusan::where('nama', 'like', "%{$row['jurusan_kode']}%")->first();
                if (!$jurusan) {
                    $this->errors[] = "❌ Jurusan dengan kode '{$row['jurusan_kode']}' tidak ditemukan di baris " . ($this->processedRows + 1);
                    DB::rollBack();
                    return null;
                }
            }

            // 2. Cari atau buat Kelas
            $kelas = Kelas::firstOrCreate(
                [
                    'tingkat' => $row['tingkat'],
                    'jurusan_id' => $jurusan->id,
                ],
                [
                    'nama' => $row['tingkat'] . ' ' . $jurusan->nama,
                ]
            );

            // 3. Cari Guru berdasarkan NIP (optional)
            $guruId = null;
            if (!empty($row['wali_kelas_nip'])) {
                $guru = Guru::where('nip', $row['wali_kelas_nip'])->first();
                if ($guru) {
                    $guruId = $guru->id;
                } else {
                    $this->errors[] = "⚠️ Guru dengan NIP '{$row['wali_kelas_nip']}' tidak ditemukan di baris " . ($this->processedRows + 1);
                }
            }

            // 4. Cari Konsentrasi Keahlian (optional)
            $konkeId = null;
            if (!empty($row['konsentrasi_keahlian_id'])) {
                $konke = KonsentrasiKeahlian::find($row['konsentrasi_keahlian_id']);
                if ($konke) {
                    $konkeId = $konke->id;
                } else {
                    $this->errors[] = "⚠️ Konsentrasi Keahlian dengan ID '{$row['konsentrasi_keahlian_id']}' tidak ditemukan di baris " . ($this->processedRows + 1);
                }
            }

            // 5. CEK DUPLIKAT - Cari berdasarkan kombinasi yang lebih akurat
            $rombel = Rombel::where('nama', $row['nama_rombel'])
                ->where('kelas_id', $kelas->id)
                ->first();

            // Jika tidak ditemukan dengan kelas_id, coba cari berdasarkan nama saja (untuk berjaga-jaga)
            if (!$rombel) {
                $rombel = Rombel::where('nama', $row['nama_rombel'])->first();
            }

            if ($rombel) {
                // UPDATE jika sudah ada
                $rombel->kelas_id = $kelas->id;
                if ($guruId) {
                    $rombel->guru_id = $guruId;
                }
                if ($konkeId) {
                    $rombel->id_konke = $konkeId;
                }
                $rombel->save();
                $this->updatedCount++;
                $this->successCount++;
                
                // Log untuk debugging
                Log::info("KelasImport: Update rombel ID {$rombel->id} - {$rombel->nama}");
            } else {
                // CREATE baru
                $newRombel = Rombel::create([
                    'kelas_id' => $kelas->id,
                    'nama' => $row['nama_rombel'],
                    'guru_id' => $guruId,
                    'id_konke' => $konkeId,
                ]);
                $this->createdCount++;
                $this->successCount++;
                
                Log::info("KelasImport: Create rombel ID {$newRombel->id} - {$newRombel->nama}");
            }

            DB::commit();
            return null;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->errors[] = "❌ Error di baris " . ($this->processedRows + 1) . ": " . $e->getMessage();
            Log::error('Kelas import error', [
                'row' => $row,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function rules(): array
    {
        return [
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_kode' => 'required|string',
            'nama_rombel' => 'required|string|max:255',
            'konsentrasi_keahlian_id' => 'nullable|integer|exists:konsentrasi_keahlian,id',
            'wali_kelas_nip' => 'nullable|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'tingkat.required' => 'Kolom Tingkat harus diisi (X, XI, XII)',
            'tingkat.in' => 'Tingkat harus X, XI, atau XII',
            'jurusan_kode.required' => 'Kolom Jurusan (Kode) harus diisi',
            'nama_rombel.required' => 'Kolom Nama Rombel harus diisi',
            'konsentrasi_keahlian_id.exists' => 'ID Konsentrasi Keahlian tidak valid',
        ];
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getUpdatedCount()
    {
        return $this->updatedCount;
    }

    public function getCreatedCount()
    {
        return $this->createdCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getProcessedRows()
    {
        return $this->processedRows;
    }
}