<?php

namespace App\Exports;

use App\Models\DataSiswa as Siswa;
use App\Models\MataPelajaran;
use App\Models\Kurikulum;
use App\Models\Jurusan;
use App\Models\KonsentrasiKeahlian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class NilaiRaportTemplateByFilters implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    protected $kurikulumIds;
    protected $jurusanIds;
    protected $tingkatLevels;
    protected $konsentrasiIds;
    protected $mataPelajarans;
    protected $headersCount = 0;

    public function __construct($kurikulumIds = [], $jurusanIds = [], $tingkatLevels = [], $konsentrasiIds = [])
    {
        $this->kurikulumIds = is_array($kurikulumIds) ? array_filter($kurikulumIds) : (array_filter([$kurikulumIds]));
        $this->jurusanIds = is_array($jurusanIds) ? array_filter($jurusanIds) : (array_filter([$jurusanIds]));
        $this->tingkatLevels = is_array($tingkatLevels) ? array_filter($tingkatLevels) : (array_filter([$tingkatLevels]));
        $this->konsentrasiIds = is_array($konsentrasiIds) ? array_filter($konsentrasiIds) : (array_filter([$konsentrasiIds]));

        $this->loadMataPelajaran();
    }

    protected function getFormattedTingkatVariants(): array
    {
        $variants = [];
        foreach ($this->tingkatLevels as $t) {
            $val = trim((string)$t);
            $variants[] = $val;

            $cleaned = preg_replace('/[^0-9]/', '', $val);
            if (!empty($cleaned)) {
                $num = (int)$cleaned;
                $variants[] = $num;
                $variants[] = (string)$num;
                if ($num === 10) $variants[] = 'X';
                if ($num === 11) $variants[] = 'XI';
                if ($num === 12) $variants[] = 'XII';
            } else {
                $upper = strtoupper($val);
                if ($upper === 'X') { $variants[] = 10; $variants[] = '10'; }
                if ($upper === 'XI') { $variants[] = 11; $variants[] = '11'; }
                if ($upper === 'XII') { $variants[] = 12; $variants[] = '12'; }
            }
        }
        return array_unique($variants);
    }

    protected function loadMataPelajaran()
    {
        $tingkatVariants = $this->getFormattedTingkatVariants();
        $mataPelajaranQuery = MataPelajaran::query();

        if (!empty($this->kurikulumIds)) {
            $mataPelajaranQuery->whereHas('kurikulums', function ($q) {
                $q->whereIn('kurikulum_id', $this->kurikulumIds);
            });
        }

        if (!empty($this->jurusanIds)) {
            $mataPelajaranQuery->whereHas('jurusans', function ($q) {
                $q->whereIn('jurusan_id', $this->jurusanIds);
            });
        }

        if (!empty($tingkatVariants)) {
            $mataPelajaranQuery->whereHas('tingkats', function ($q) use ($tingkatVariants) {
                $q->where(function ($sub) use ($tingkatVariants) {
                    $sub->whereIn('tingkat', $tingkatVariants);
                    if (\Schema::hasColumn('mata_pelajaran_tingkat', 'tingkat_id')) {
                        $sub->orWhereIn('tingkat_id', $tingkatVariants);
                    }
                });
            });
        }

        $this->mataPelajarans = $mataPelajaranQuery->orderBy('kelompok')->orderBy('urutan')->get();
    }

    public function title(): string
    {
        return 'TEMPLATE NILAI RAPOR';
    }

    public function headings(): array
    {
        $headerRow = ['No', 'NIS', 'NISN', 'Nama Siswa', 'Rombel', 'Semester', 'Tahun Ajaran'];
        foreach ($this->mataPelajarans as $mapel) {
            $headerRow[] = $mapel->nama;
        }

        $this->headersCount = count($headerRow);
        return $headerRow;
    }

    public function collection()
    {
        $siswaQuery = Siswa::with(['rombel.kelas.jurusan']);

        if (!empty($this->jurusanIds)) {
            $siswaQuery->whereHas('rombel.kelas.jurusan', function ($q) {
                $q->whereIn('id', $this->jurusanIds);
            });
        }

        $tingkatVariants = $this->getFormattedTingkatVariants();
        if (!empty($tingkatVariants)) {
            $siswaQuery->whereHas('rombel.kelas', function ($q) use ($tingkatVariants) {
                $q->whereIn('tingkat', $tingkatVariants);
            });
        }

        $siswas = $siswaQuery->get();

        $data = collect();
        $no = 1;

        foreach ($siswas as $siswa) {
            $row = [
                $no++,
                $siswa->nis ?? '-',
                $siswa->nisn ?? '-',
                $siswa->nama_lengkap ?? '-',
                $siswa->rombel ? $siswa->rombel->nama : '-',
                '',
                '',
            ];

            foreach ($this->mataPelajarans as $mapel) {
                $row[] = '';
            }

            $data->push($row);
        }

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($this->headersCount);
        $highestRow = $sheet->getHighestRow();

        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => '000000']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'D9D9D9']],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ]);

        if ($highestRow >= 2) {
            $sheet->getStyle("A2:{$lastColumn}{$highestRow}")->applyFromArray([
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'D9D9D9']],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            $sheet->getStyle("A2:C{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E2:E{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        return [];
    }
}