<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithDrawings; 
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing; 

class AbsensiGuruExport implements FromView, ShouldAutoSize, WithColumnFormatting, WithDrawings
{
    protected $gurus;
    protected $hari;
    protected $tanggal;

    public function __construct($gurus, $hari, $tanggal)
    {
        $this->gurus = $gurus;
        $this->hari = $hari;
        $this->tanggal = $tanggal;
    }

    public function view(): View
    {
        return view('tu_kepegawaian.guru.excel_absensi', [
            'gurus'   => $this->gurus,
            'hari'    => $this->hari,
            'tanggal' => $this->tanggal,
        ]);
    }

    
    public function drawings()
    {
    $drawing = new Drawing();
    $drawing->setName('Logo Jawa Barat');
    $drawing->setDescription('Logo Pemprov Jabar');
   
    $drawing->setPath(public_path('images/logoJabar.png')); 
    
    $drawing->setHeight(100); 
    $drawing->setCoordinates('A1'); 
    $drawing->setOffsetX(20);
    $drawing->setOffsetY(5);

    return $drawing;
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_TEXT, 
        ];
    }
}