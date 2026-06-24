<?php

namespace App\Exports;

use App\Models\DataSiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class SiswaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $search;
    protected $rombel;
    protected $tingkat;

    public function __construct(array $filters = [])
    {
        $this->search = $filters['search'] ?? null;
        $this->rombel = $filters['rombel'] ?? null;
        $this->tingkat = $filters['tingkat'] ?? null;
    }

    public function collection()
    {
        $query = DataSiswa::with(['rombel.kelas.jurusan'])->orderBy('nama_lengkap');

        if ($this->tingkat) {
            $query->whereHas('rombel.kelas', function ($q) {
                $q->where('tingkat', $this->tingkat);
            });
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_lengkap', 'like', "%{$this->search}%")
                    ->orWhere('nis', 'like', "%{$this->search}%")
                    ->orWhere('nisn', 'like', "%{$this->search}%");
            });
        }

        if ($this->rombel) {
            $query->where('rombel_id', $this->rombel);
        }

        return $query->get()->map(function ($siswa, $index) {
            $rombelModel = $siswa->rombel;
            $kelasModel = $rombelModel ? $rombelModel->kelas : null;
            $jurusanModel = $kelasModel ? $kelasModel->jurusan : null;

            $rombel = $rombelModel ? $rombelModel->nama : '';
            $kelas = $kelasModel ? $kelasModel->tingkat : '';
            $jurusan = $jurusanModel ? $jurusanModel->nama : '';
            $tanggalLahir = $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') : '';

            return [
                    'No' => $index + 1,
                    'NIS' => $siswa->nis ?? '',
                    'NISN' => $siswa->nisn ?? '',
                    'Nama Lengkap' => $siswa->nama_lengkap ?? '',
                    'Jenis Kelamin' => $siswa->jenis_kelamin ?? '',
                    'Tempat Lahir' => $siswa->tempat_lahir ?? '',
                    'Tanggal Lahir' => $tanggalLahir,
                    'Alamat' => $siswa->alamat ?? '',
                    'Kelas' => $kelas,
                    'Rombel' => $rombel,
                    'Jurusan' => $jurusan,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'NISN',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Alamat',
            'Kelas',
            'Rombel',
            'Jurusan',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                $sheet->getStyle('A1:' . $highestColumn . '1')->getFont()->setBold(true);
                $sheet->getStyle('A1:' . $highestColumn . '1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFDDDDDD');

                $sheet->getStyle('A1:' . $highestColumn . $highestRow)->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('A1:' . $highestColumn . $highestRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            },
        ];
    }
}
