<?php

namespace App\Exports;

use App\Models\Rombel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class SiswaImportTemplate implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * Return sample data
     */
    public function array(): array
    {
        // Get sample data - 3 example rows
        $rombelList = Rombel::select('id', 'nama')->limit(3)->get();
        
        $rows = [
            [
                'NIS' => '001',
                'NISN' => '0001234567',
                'Nama Lengkap' => 'Ahmad Rizki Pratama',
                'Jenis Kelamin' => 'Laki-laki',
                'Tempat Lahir' => 'Jakarta',
                'Tanggal Lahir' => '2008-01-15',
                'Kewarganegaraan' => 'Indonesia',
                'Agama' => 'Islam',
                'RT' => '001',
                'RW' => '005',
                'Dusun' => 'Merdeka Jaya',
                'Kelurahan' => 'Kelurahan Merdeka',
                'Kecamatan' => 'Jakarta Pusat',
                'Kode Pos' => '12345',
                'Nama Ayah' => 'Rizki Pratama',
                'Nama Ibu' => 'Siti Nurhaliza',
                'Pekerjaan Ayah' => 'Pegawai Negeri Sipil',
                'Alamat Rumah' => 'Jl. Merdeka No. 123, Jakarta',
                'Nama Wali' => '-',
                'Pekerjaan Wali' => '-',
                'Alamat Wali' => '-',
                'Mulai Tanggal Diterima' => '2023-07-01',
                'Asal Sekolah' => 'SMP Negeri 1 Jakarta',
            ],
            [
                'NIS' => '002',
                'NISN' => '0001234568',
                'Nama Lengkap' => 'Siti Nurhaliza',
                'Jenis Kelamin' => 'Perempuan',
                'Tempat Lahir' => 'Bandung',
                'Tanggal Lahir' => '2008-03-20',
                'Kewarganegaraan' => 'Indonesia',
                'Agama' => 'Islam',
                'RT' => '002',
                'RW' => '003',
                'Dusun' => 'Sudirman Raya',
                'Kelurahan' => 'Kelurahan Sudirman',
                'Kecamatan' => 'Bandung Kota',
                'Kode Pos' => '40123',
                'Nama Ayah' => 'Ahmad Suryaman',
                'Nama Ibu' => 'Nurlela Wijaya',
                'Pekerjaan Ayah' => 'Pengusaha',
                'Alamat Rumah' => 'Jl. Sudirman No. 456, Bandung',
                'Nama Wali' => '-',
                'Pekerjaan Wali' => '-',
                'Alamat Wali' => '-',
                'Mulai Tanggal Diterima' => '2023-07-01',
                'Asal Sekolah' => 'SMP Negeri 2 Bandung',
            ],
            [
                'NIS' => '003',
                'NISN' => '0001234569',
                'Nama Lengkap' => 'Budi Santoso',
                'Jenis Kelamin' => 'Laki-laki',
                'Tempat Lahir' => 'Surabaya',
                'Tanggal Lahir' => '2008-05-10',
                'Kewarganegaraan' => 'Indonesia',
                'Agama' => 'Islam',
                'RT' => '003',
                'RW' => '001',
                'Dusun' => 'Ahmad Yani',
                'Kelurahan' => 'Kelurahan Ahmad Yani',
                'Kecamatan' => 'Surabaya Pusat',
                'Kode Pos' => '60123',
                'Nama Ayah' => 'Santoso Wijaya',
                'Nama Ibu' => 'Endang Suryani',
                'Pekerjaan Ayah' => 'Wiraswasta',
                'Alamat Rumah' => 'Jl. Ahmad Yani No. 789, Surabaya',
                'Nama Wali' => '-',
                'Pekerjaan Wali' => '-',
                'Alamat Wali' => '-',
                'Mulai Tanggal Diterima' => '2023-07-01',
                'Asal Sekolah' => 'SMP Negeri 3 Surabaya',
            ],
        ];

        return $rows;
    }

    public function headings(): array
    {
        return [
            'NIS',
            'NISN',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Kewarganegaraan',
            'Agama',
            'RT',
            'RW',
            'Dusun',
            'Kelurahan',
            'Kecamatan',
            'Kode Pos',
            'Nama Ayah',
            'Nama Ibu',
            'Pekerjaan Ayah',
            'Alamat Rumah',
            'Nama Wali',
            'Pekerjaan Wali',
            'Alamat Wali',
            'Mulai Tanggal Diterima',
            'Asal Sekolah',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Style header row (row 1)
                $sheet->getStyle('A1:W1')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));
                $sheet->getStyle('A1:W1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF2F53FF');
                $sheet->getStyle('A1:W1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getRowDimension(1)->setRowHeight(20);

                // Add borders
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A1:W' . $highestRow)->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
                    ->getColor()->setARGB('FFD3D3D3');

                // Column width
                $sheet->getColumnDimension('A')->setWidth(12);  // NIS
                $sheet->getColumnDimension('B')->setWidth(14);  // NISN
                $sheet->getColumnDimension('C')->setWidth(20);  // Nama Lengkap
                $sheet->getColumnDimension('D')->setWidth(14);  // Jenis Kelamin
                $sheet->getColumnDimension('E')->setWidth(16);  // Tempat Lahir
                $sheet->getColumnDimension('F')->setWidth(14);  // Tanggal Lahir
                $sheet->getColumnDimension('G')->setWidth(16);  // Kewarganegaraan
                $sheet->getColumnDimension('H')->setWidth(10);  // Agama
                $sheet->getColumnDimension('I')->setWidth(8);   // RT
                $sheet->getColumnDimension('J')->setWidth(8);   // RW
                $sheet->getColumnDimension('K')->setWidth(16);  // Dusun
                $sheet->getColumnDimension('L')->setWidth(18);  // Kelurahan
                $sheet->getColumnDimension('M')->setWidth(16);  // Kecamatan
                $sheet->getColumnDimension('N')->setWidth(10);  // Kode Pos
                $sheet->getColumnDimension('O')->setWidth(16);  // Nama Ayah
                $sheet->getColumnDimension('P')->setWidth(16);  // Nama Ibu
                $sheet->getColumnDimension('Q')->setWidth(20);  // Pekerjaan Ayah
                $sheet->getColumnDimension('R')->setWidth(25);  // Alamat Rumah
                $sheet->getColumnDimension('S')->setWidth(16);  // Nama Wali
                $sheet->getColumnDimension('T')->setWidth(20);  // Pekerjaan Wali
                $sheet->getColumnDimension('U')->setWidth(25);  // Alamat Wali
                $sheet->getColumnDimension('V')->setWidth(18);  // Mulai Tanggal Diterima
                $sheet->getColumnDimension('W')->setWidth(20);  // Asal Sekolah

                // Format date columns
                $sheet->getStyle('F2:F' . $highestRow)->getNumberFormat()
                    ->setFormatCode('DD-MM-YYYY');
                $sheet->getStyle('V2:V' . $highestRow)->getNumberFormat()
                    ->setFormatCode('DD-MM-YYYY');

                // Freeze first row (header only)
                $sheet->freezePane('A2');
            },
        ];
    }
}
