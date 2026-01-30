<?php

namespace App\Exports;

use App\Models\DataSiswa;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class KaprogSiswaByAngkatanExport implements WithMultipleSheets
{
    protected $jurusanId;
    protected $jurusanName;

    public function __construct($jurusanId, $jurusanName = 'All')
    {
        $this->jurusanId = $jurusanId;
        $this->jurusanName = $jurusanName;
    }

    public function sheets(): array
    {
        $sheets = [];
        $tingkats = ['X', 'XI', 'XII'];

        foreach ($tingkats as $tingkat) {
            $sheets[] = new KaprogSiswaAngkatanSheet($this->jurusanId, $tingkat, $this->jurusanName);
        }

        return $sheets;
    }
}
