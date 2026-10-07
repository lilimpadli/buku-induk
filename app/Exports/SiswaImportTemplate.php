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
        $rombelList = Rombel::select('nama')->limit(3)->get();

        $rombelNames = $rombelList->isNotEmpty()
            ? $rombelList->pluck('nama')->toArray()
            : ['10 IPA 1', '10 IPA 2', '10 IPS 1'];

        $rows = [
            [
                // ===== 24 KOLOM LAMA =====
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
                'Nama Rombel' => $rombelNames[0] ?? '10 IPA 1',

                // ===== 40 KOLOM DAPODIK =====
                'NIK' => '',
                'No KK' => '',
                'No Registrasi Akta Lahir' => '',
                'Kebutuhan Khusus' => 'Tidak ada',
                'Alat Transportasi' => 'Jalan kaki',
                'Jenis Tinggal' => 'Bersama orang tua',
                'E-Mail' => '',
                'Tahun Lahir Ayah' => '1975',
                'Jenjang Pendidikan Ayah' => 'SMA / sederajat',
                'Penghasilan Ayah' => 'Rp. 1,000,000 - Rp. 1,999,999',
                'NIK Ayah' => '',
                'Tahun Lahir Ibu' => '1978',
                'Jenjang Pendidikan Ibu' => 'SMP / sederajat',
                'Penghasilan Ibu' => 'Tidak Berpenghasilan',
                'NIK Ibu' => '',
                'Tahun Lahir Wali' => '',
                'Jenjang Pendidikan Wali' => '',
                'Penghasilan Wali' => '',
                'NIK Wali' => '',
                'Penerima KPS' => 'Tidak',
                'No. KPS' => '',
                'Penerima KIP' => 'Tidak',
                'Nomor KIP' => '',
                'Nama di KIP' => '',
                'Nomor KKS' => '',
                'Bank' => '',
                'Nomor Rekening Bank' => '',
                'Rekening Atas Nama' => '',
                'Layak PIP (usulan dari sekolah)' => 'Tidak',
                'Alasan Layak PIP' => '',
                'SKHUN' => '',
                'No Peserta Ujian Nasional' => '',
                'No Seri Ijazah' => '',
                'Berat Badan' => '',
                'Tinggi Badan' => '',
                'Lingkar Kepala' => '',
                'Jml. Saudara Kandung' => '1',
                'Jarak Rumah ke Sekolah (KM)' => '',
                'Lintang' => '',
                'Bujur' => '',
            ],
            [
                // ===== 24 KOLOM LAMA =====
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
                'Nama Rombel' => $rombelNames[1] ?? '10 IPA 2',

                // ===== 40 KOLOM DAPODIK =====
                'NIK' => '',
                'No KK' => '',
                'No Registrasi Akta Lahir' => '',
                'Kebutuhan Khusus' => 'Tidak ada',
                'Alat Transportasi' => 'Jalan kaki',
                'Jenis Tinggal' => 'Bersama orang tua',
                'E-Mail' => '',
                'Tahun Lahir Ayah' => '1970',
                'Jenjang Pendidikan Ayah' => 'S1',
                'Penghasilan Ayah' => 'Rp. 2,000,000 - Rp. 4,999,999',
                'NIK Ayah' => '',
                'Tahun Lahir Ibu' => '1975',
                'Jenjang Pendidikan Ibu' => 'SMA / sederajat',
                'Penghasilan Ibu' => 'Tidak Berpenghasilan',
                'NIK Ibu' => '',
                'Tahun Lahir Wali' => '',
                'Jenjang Pendidikan Wali' => '',
                'Penghasilan Wali' => '',
                'NIK Wali' => '',
                'Penerima KPS' => 'Tidak',
                'No. KPS' => '',
                'Penerima KIP' => 'Tidak',
                'Nomor KIP' => '',
                'Nama di KIP' => '',
                'Nomor KKS' => '',
                'Bank' => '',
                'Nomor Rekening Bank' => '',
                'Rekening Atas Nama' => '',
                'Layak PIP (usulan dari sekolah)' => 'Tidak',
                'Alasan Layak PIP' => '',
                'SKHUN' => '',
                'No Peserta Ujian Nasional' => '',
                'No Seri Ijazah' => '',
                'Berat Badan' => '',
                'Tinggi Badan' => '',
                'Lingkar Kepala' => '',
                'Jml. Saudara Kandung' => '1',
                'Jarak Rumah ke Sekolah (KM)' => '',
                'Lintang' => '',
                'Bujur' => '',
            ],
            [
                // ===== 24 KOLOM LAMA =====
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
                'Nama Rombel' => $rombelNames[2] ?? '10 IPS 1',

                // ===== 40 KOLOM DAPODIK =====
                'NIK' => '',
                'No KK' => '',
                'No Registrasi Akta Lahir' => '',
                'Kebutuhan Khusus' => 'Tidak ada',
                'Alat Transportasi' => 'Sepeda motor',
                'Jenis Tinggal' => 'Bersama orang tua',
                'E-Mail' => '',
                'Tahun Lahir Ayah' => '1968',
                'Jenjang Pendidikan Ayah' => 'SMP / sederajat',
                'Penghasilan Ayah' => 'Rp. 1,000,000 - Rp. 1,999,999',
                'NIK Ayah' => '',
                'Tahun Lahir Ibu' => '1972',
                'Jenjang Pendidikan Ibu' => 'SMA / sederajat',
                'Penghasilan Ibu' => 'Tidak Berpenghasilan',
                'NIK Ibu' => '',
                'Tahun Lahir Wali' => '',
                'Jenjang Pendidikan Wali' => '',
                'Penghasilan Wali' => '',
                'NIK Wali' => '',
                'Penerima KPS' => 'Tidak',
                'No. KPS' => '',
                'Penerima KIP' => 'Tidak',
                'Nomor KIP' => '',
                'Nama di KIP' => '',
                'Nomor KKS' => '',
                'Bank' => '',
                'Nomor Rekening Bank' => '',
                'Rekening Atas Nama' => '',
                'Layak PIP (usulan dari sekolah)' => 'Tidak',
                'Alasan Layak PIP' => '',
                'SKHUN' => '',
                'No Peserta Ujian Nasional' => '',
                'No Seri Ijazah' => '',
                'Berat Badan' => '',
                'Tinggi Badan' => '',
                'Lingkar Kepala' => '',
                'Jml. Saudara Kandung' => '1',
                'Jarak Rumah ke Sekolah (KM)' => '',
                'Lintang' => '',
                'Bujur' => '',
            ],
        ];

        return $rows;
    }

    public function headings(): array
    {
        return [
            // 24 kolom existing
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
            'Nama Rombel',

            // 40 kolom Dapodik
            'NIK',
            'No KK',
            'No Registrasi Akta Lahir',
            'Kebutuhan Khusus',
            'Alat Transportasi',
            'Jenis Tinggal',
            'E-Mail',
            'Tahun Lahir Ayah',
            'Jenjang Pendidikan Ayah',
            'Penghasilan Ayah',
            'NIK Ayah',
            'Tahun Lahir Ibu',
            'Jenjang Pendidikan Ibu',
            'Penghasilan Ibu',
            'NIK Ibu',
            'Tahun Lahir Wali',
            'Jenjang Pendidikan Wali',
            'Penghasilan Wali',
            'NIK Wali',
            'Penerima KPS',
            'No. KPS',
            'Penerima KIP',
            'Nomor KIP',
            'Nama di KIP',
            'Nomor KKS',
            'Bank',
            'Nomor Rekening Bank',
            'Rekening Atas Nama',
            'Layak PIP (usulan dari sekolah)',
            'Alasan Layak PIP',
            'SKHUN',
            'No Peserta Ujian Nasional',
            'No Seri Ijazah',
            'Berat Badan',
            'Tinggi Badan',
            'Lingkar Kepala',
            'Jml. Saudara Kandung',
            'Jarak Rumah ke Sekolah (KM)',
            'Lintang',
            'Bujur',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // ============================================
                // STYLE HEADER (A1 s.d. AV1 = 64 kolom)
                // ============================================
                $sheet->getStyle('A1:AV1')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));
                $sheet->getStyle('A1:AV1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF2F53FF');
                $sheet->getStyle('A1:AV1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:AV1')->getAlignment()->setWrapText(true);
                $sheet->getRowDimension(1)->setRowHeight(30);

                // ============================================
                // BORDER SEMUA SEL
                // ============================================
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A1:AV' . $highestRow)->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
                    ->getColor()->setARGB('FFD3D3D3');

                // ============================================
                // WIDTH KOLOM — 24 kolom lama
                // ============================================
                $widths = [
                    'A' => 12,  // NIS
                    'B' => 14,  // NISN
                    'C' => 20,  // Nama Lengkap
                    'D' => 14,  // Jenis Kelamin
                    'E' => 16,  // Tempat Lahir
                    'F' => 14,  // Tanggal Lahir
                    'G' => 16,  // Kewarganegaraan
                    'H' => 10,  // Agama
                    'I' => 8,   // RT
                    'J' => 8,   // RW
                    'K' => 16,  // Dusun
                    'L' => 18,  // Kelurahan
                    'M' => 16,  // Kecamatan
                    'N' => 10,  // Kode Pos
                    'O' => 16,  // Nama Ayah
                    'P' => 16,  // Nama Ibu
                    'Q' => 20,  // Pekerjaan Ayah
                    'R' => 25,  // Alamat Rumah
                    'S' => 16,  // Nama Wali
                    'T' => 20,  // Pekerjaan Wali
                    'U' => 25,  // Alamat Wali
                    'V' => 18,  // Mulai Tanggal Diterima
                    'W' => 20,  // Asal Sekolah
                    'X' => 20,  // Nama Rombel
                ];
                foreach ($widths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }

                // ============================================
                // WIDTH KOLOM — 40 kolom Dapodik (Y s.d. AV)
                // ============================================
                foreach (range('Y', 'AV') as $col) {
                    $sheet->getColumnDimension($col)->setWidth(20);
                }

                // ============================================
                // FORMAT TANGGAL
                // ============================================
                $sheet->getStyle('F2:F' . $highestRow)->getNumberFormat()
                    ->setFormatCode('DD-MM-YYYY');
                $sheet->getStyle('V2:V' . $highestRow)->getNumberFormat()
                    ->setFormatCode('DD-MM-YYYY');

                // ============================================
                // FREEZE HEADER
                // ============================================
                $sheet->freezePane('A2');
            },
        ];
    }
}