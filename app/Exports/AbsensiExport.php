<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use Illuminate\Contracts\View\View;

class AbsensiExport implements FromView, WithColumnWidths, WithEvents
{
    protected $siswa;
    protected $rombel;
    protected $semester;
    protected $tahunAjaran;
    protected $jumlahLaki;
    protected $jumlahPerempuan;

    public function __construct($siswa, $rombel, $semester, $tahunAjaran, $jumlahLaki, $jumlahPerempuan)
    {
        $this->siswa = $siswa;
        $this->rombel = $rombel;
        $this->semester = $semester;
        $this->tahunAjaran = $tahunAjaran;
        $this->jumlahLaki = $jumlahLaki;
        $this->jumlahPerempuan = $jumlahPerempuan;
    }

    public function view(): View
    {
        return view('exports.absensi-excel', [
            'siswa' => $this->siswa,
            'rombel' => $this->rombel,
            'semester' => $this->semester,
            'tahunAjaran' => $this->tahunAjaran,
            'jumlahLaki' => $this->jumlahLaki,
            'jumlahPerempuan' => $this->jumlahPerempuan
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,    // Urt
            'B' => 15,   // NISN
            'C' => 12,   // NIS
            'D' => 30,   // Nama
            'E' => 5,    // JK
            'F' => 5,    // Tgl 1
            'G' => 5,    // Tgl 2
            'H' => 5,    // Tgl 3
            'I' => 5,    // Tgl 4
            'J' => 5,    // Tgl 5
            'K' => 5,    // Tgl 6
            'L' => 5,    // Tgl 7
            'M' => 5,    // Tgl 8
            'N' => 5,    // S
            'O' => 5,    // I
            'P' => 5,    // A
            'Q' => 10,   // Persen
            'R' => 15,   // KET
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Set orientasi dan ukuran kertas (F4 Portrait)
                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);
                $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_FOLIO);
                
                // Fit to width 1 page
                $sheet->getPageSetup()->setFitToWidth(1);
                $sheet->getPageSetup()->setFitToHeight(0);

                // Set Margin
                $sheet->getPageMargins()->setTop(0.4);
                $sheet->getPageMargins()->setBottom(0.4);
                $sheet->getPageMargins()->setLeft(0.4);
                $sheet->getPageMargins()->setRight(0.4);

                // Set Default Font
                $sheet->getParent()->getDefaultStyle()->getFont()->setName('Times New Roman');
                $sheet->getParent()->getDefaultStyle()->getFont()->setSize(10);
            },
        ];
    }
}