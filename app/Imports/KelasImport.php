<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Rombel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Throwable;

class KelasImport implements ToModel, WithHeadingRow, SkipsEmptyRows, SkipsOnError
{
    protected $errors = [];
    protected $successCount = 0;
    protected $rowCount = 0;
    protected $skippedEmptyRows = 0;

    public function model(array $row)
    {
        $this->rowCount++;
        $row = $this->normalizeRow($row);

        if (empty($row['nama_rombel']) && empty($row['tingkat']) && empty($row['jurusan'])) {
            $this->skippedEmptyRows++;
            return null;
        }

        $namaRombel = trim($row['nama_rombel'] ?? '');
        $tingkat = strtoupper(trim($row['tingkat'] ?? ''));
        $jurusanName = trim($row['jurusan'] ?? '');

        if (empty($namaRombel) || empty($tingkat) || empty($jurusanName)) {
            $this->errors[] = "Baris {$this->rowCount}: Kolom Tingkat, Jurusan, dan Nama Rombel wajib diisi.";
            return null;
        }

        $jurusan = Jurusan::where('nama', $jurusanName)->first();
        if (!$jurusan) {
            $this->errors[] = "Baris {$this->rowCount}: Jurusan '{$jurusanName}' tidak ditemukan.";
            return null;
        }

        $kelas = Kelas::firstOrCreate([
            'tingkat' => $tingkat,
            'jurusan_id' => $jurusan->id,
        ]);

        Rombel::updateOrCreate(
            ['nama' => $namaRombel],
            ['kelas_id' => $kelas->id]
        );

        $this->successCount++;
        return null;
    }

    protected function normalizeRow(array $row): array
    {
        $normalized = [];
        foreach ($row as $key => $value) {
            $normalizedKey = Str::of($key)->lower()->replace(' ', '_')->replace('-', '_')->__toString();
            $normalized[$normalizedKey] = $value;
        }
        return $normalized;
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

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function onError(Throwable $e)
    {
        Log::error('KelasImport error', ['error' => $e->getMessage()]);
        $this->errors[] = 'Error teknis: ' . $e->getMessage();
    }
}
