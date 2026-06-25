<?php

namespace App\Exports;

use App\Models\DataSiswa;
use App\Models\MataPelajaran;
use App\Models\Jurusan;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class NilaiRaportTemplateByJurusan implements FromArray, WithStyles, WithColumnWidths
{
    protected $jurusanId;
    protected $semester;
    protected $tahunAjaran;

    public function __construct($jurusanId = null, $semester = null, $tahunAjaran = null)
    {
        $this->jurusanId = $jurusanId;
        $this->semester = $semester;
        $this->tahunAjaran = $tahunAjaran;
    }

    public function array(): array
    {
        // Get students filtered by jurusan (kelas->jurusan_id)
        $siswasQuery = DataSiswa::with('rombel');
        if ($this->jurusanId) {
            $siswasQuery->whereHas('rombel.kelas', function ($q) {
                $q->where('jurusan_id', $this->jurusanId);
            });
        }

        $siswas = $siswasQuery->orderBy('nama_lengkap')->get();

        if ($siswas->isEmpty()) {
            return [['Tidak ada data siswa']];
        }

        // Get mata pelajaran for jurusan if provided, otherwise all
        if ($this->jurusanId) {
            $jurusan = Jurusan::find($this->jurusanId);
            $mapelList = $jurusan ? $jurusan->mataPelajarans()->orderBy('urutan')->get()->toArray() : [];
        } else {
            $mapelList = MataPelajaran::orderBy('urutan')->get()->toArray();
        }

        $data = [];

        // School Header
        $data[] = ['PEMERINTAH KOTA KAWALI'];
        $data[] = ['DINAS PENDIDIKAN'];
        $data[] = ['SEKOLAH MENENGAH KEJURUAN NEGERI 1 KAWALI'];
        $data[] = [];

        // Title
        $data[] = ['TEMPLATE INPUT NILAI RAPORT'];
        $data[] = [];

        // Info
        $data[] = ['Jurusan:', $jurusan->nama ?? ($this->jurusanId ? 'Terpilih' : 'Semua')];
        $data[] = ['Semester:', $this->semester ?? 'Semua'];
        $data[] = ['Tahun Ajaran:', $this->tahunAjaran ?? 'Semua'];
        $data[] = ['Instruksi: Isikan nilai siswa pada kolom mata pelajaran. Gunakan angka 0-100.'];
        $data[] = [];

        // Table header row
        $headerRow = ['NO', 'NISN', 'NIS', 'NAMA SISWA'];
        foreach ($mapelList as $mapel) {
            $headerRow[] = strtoupper(substr($mapel['nama'] ?? 'MAPEL', 0, 10));
        }
        $headerRow[] = 'SAKIT';
        $headerRow[] = 'IZIN';
        $headerRow[] = 'ALPA';

        $data[] = $headerRow;

        // Data rows with sample data
        $no = 1;
        foreach ($siswas as $siswa) {
            $row = [$no, $siswa->nisn, $siswa->nis, $siswa->nama_lengkap];

            // Add empty cells for mata pelajaran
            foreach ($mapelList as $mapel) {
                $row[] = ''; // empty for user
            }

            // Add empty cells for kehadiran
            $row[] = '0';
            $row[] = '0';
            $row[] = '0';

            $data[] = $row;
            $no++;
        }

        return $data;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 12,
            'C' => 12,
            'D' => 25,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Minimal styling to keep template readable
        $sheet->getRowDimension(1)->setRowHeight(20);
        $sheet->getRowDimension(5)->setRowHeight(22);
        $sheet->freezePane('A13');
        return [];
    }
}
