<?php

namespace App\Imports;

use App\Models\Rombel;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Guru;
use App\Models\KonsentrasiKeahlian;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class KelasImport extends DefaultValueBinder implements ToModel, WithHeadingRow, WithCustomValueBinder, SkipsEmptyRows
{
    private $errors = [];
    private $successCount = 0;
    private $processedRows = 0;
    private $updatedCount = 0;
    private $createdCount = 0;

    public function bindValue(Cell $cell, $value)
    {
        if ($value === null || $value === '') {
            return parent::bindValue($cell, $value);
        }
        if (is_numeric($value) && !is_string($value)) {
            return parent::bindValue($cell, $value);
        }
        $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);
        return true;
    }

    public function model(array $row)
    {
        $this->processedRows++;

        // AMBIL BY POSISI — kolom A=0, B=1, C=2, D=3, E=4
        $values = array_values($row);
        $tingkat      = $values[0] ?? null;
        $jurusanKode  = $values[1] ?? null;
        $namaRombel   = $values[2] ?? null;
        $konkeId      = $values[3] ?? null;
        $waliKelasNip = $values[4] ?? null;

        // Normalisasi tingkat
        if ($tingkat !== null) {
            $tingkat = strtoupper(trim((string) $tingkat));
            if ($tingkat === '10') $tingkat = 'X';
            if ($tingkat === '11') $tingkat = 'XI';
            if ($tingkat === '12') $tingkat = 'XII';
        }

        // Normalisasi jurusan kode
        if ($jurusanKode !== null) {
            $jurusanKode = strtoupper(trim((string) $jurusanKode));
        }

        // Normalisasi nama rombel
        if ($namaRombel !== null) {
            $namaRombel = trim((string) $namaRombel);
        }

        try {
            DB::beginTransaction();

            // Validasi manual
            if (empty($tingkat)) {
                $this->errors[] = "❌ Baris " . ($this->processedRows + 1) . ": Kolom Tingkat kosong.";
                DB::rollBack();
                return null;
            }

            if (!in_array($tingkat, ['X', 'XI', 'XII'])) {
                $this->errors[] = "❌ Baris " . ($this->processedRows + 1) . ": Tingkat '{$tingkat}' tidak valid.";
                DB::rollBack();
                return null;
            }

            if (empty($jurusanKode)) {
                $this->errors[] = "❌ Baris " . ($this->processedRows + 1) . ": Kolom Jurusan (Kode) kosong.";
                DB::rollBack();
                return null;
            }

            if (empty($namaRombel)) {
                $this->errors[] = "❌ Baris " . ($this->processedRows + 1) . ": Kolom Nama Rombel kosong.";
                DB::rollBack();
                return null;
            }

            // Cari Jurusan
            $jurusan = Jurusan::where('kode', $jurusanKode)->first();
            if (!$jurusan) {
                $jurusan = Jurusan::where('nama', 'like', "%{$jurusanKode}%")->first();
                if (!$jurusan) {
                    $this->errors[] = "❌ Baris " . ($this->processedRows + 1) . ": Jurusan kode '{$jurusanKode}' tidak ditemukan.";
                    DB::rollBack();
                    return null;
                }
            }

            // Cari atau buat Kelas
            $kelas = Kelas::firstOrCreate(
                [
                    'tingkat' => $tingkat,
                    'jurusan_id' => $jurusan->id,
                ],
                [
                    'nama' => $tingkat . ' ' . $jurusan->nama,
                ]
            );

            // Cari Guru (optional)
            $guruId = null;
            if (!empty($waliKelasNip)) {
                $waliKelasNip = trim((string) $waliKelasNip);
                $guru = Guru::where('nip', $waliKelasNip)->first();
                if ($guru) {
                    $guruId = $guru->id;
                } else {
                    $this->errors[] = "⚠️ Baris " . ($this->processedRows + 1) . ": Guru NIP '{$waliKelasNip}' tidak ditemukan.";
                }
            }

            // Cari Konsentrasi Keahlian (optional)
            $konkeIdFinal = null;
            if (!empty($konkeId)) {
                $konkeIdClean = is_numeric($konkeId) ? (int) $konkeId : null;
                if ($konkeIdClean) {
                    $konke = KonsentrasiKeahlian::find($konkeIdClean);
                    if ($konke) {
                        $konkeIdFinal = $konke->id;
                    } else {
                        $this->errors[] = "⚠️ Baris " . ($this->processedRows + 1) . ": Konsentrasi Keahlian ID '{$konkeIdClean}' tidak ditemukan.";
                    }
                }
            }

            // Cek duplikat
            $rombel = Rombel::where('nama', $namaRombel)
                ->where('kelas_id', $kelas->id)
                ->first();

            if (!$rombel) {
                $rombel = Rombel::where('nama', $namaRombel)->first();
            }

            if ($rombel) {
                $rombel->kelas_id = $kelas->id;
                if ($guruId) $rombel->guru_id = $guruId;
                if ($konkeIdFinal) $rombel->id_konke = $konkeIdFinal;
                $rombel->save();
                $this->updatedCount++;
                $this->successCount++;
                Log::info("KelasImport: Update rombel ID {$rombel->id} - {$rombel->nama}");
            } else {
                $newRombel = Rombel::create([
                    'kelas_id' => $kelas->id,
                    'nama' => $namaRombel,
                    'guru_id' => $guruId,
                    'id_konke' => $konkeIdFinal,
                ]);
                $this->createdCount++;
                $this->successCount++;
                Log::info("KelasImport: Create rombel ID {$newRombel->id} - {$newRombel->nama}");
            }

            DB::commit();
            return null;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->errors[] = "❌ Baris " . ($this->processedRows + 1) . ": " . $e->getMessage();
            Log::error('Kelas import error', [
                'row' => $row,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function getSuccessCount() { return $this->successCount; }
    public function getUpdatedCount() { return $this->updatedCount; }
    public function getCreatedCount() { return $this->createdCount; }
    public function getErrors() { return $this->errors; }
    public function getProcessedRows() { return $this->processedRows; }
}