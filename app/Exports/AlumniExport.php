<?php

namespace App\Exports;

use App\Models\DataSiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AlumniExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = DataSiswa::where('status_kelulusan', 'Lulus')
            ->with(['rombel.kelas.jurusan'])
            ->whereNotNull('tanggal_lulus');

        if ($this->request->filled('tahun_ajaran')) {
            $query->whereYear('tanggal_lulus', (int) $this->request->tahun_ajaran);
        }
        if ($this->request->filled('jurusan_id')) {
            $query->whereHas('rombel.kelas.jurusan', function ($q) {
                $q->where('id', $this->request->jurusan_id);
            });
        }
        if ($this->request->filled('search')) {
            $s = $this->request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_lengkap', 'like', "%{$s}%")
                  ->orWhere('nis', 'like', "%{$s}%")
                  ->orWhere('nisn', 'like', "%{$s}%");
            });
        }

        return $query->orderBy('nama_lengkap')->get();
    }

    public function headings(): array
    {
        return [
            'No', 'NIS', 'NISN', 'Nama Lengkap', 'Jenis Kelamin',
            'Tempat Lahir', 'Tanggal Lahir', 'Jurusan', 'Rombel',
            'Tahun Lulus', 'Tanggal Lulus', 'Status',
        ];
    }

    public function map($siswa): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $siswa->nis ?? '-',
            $siswa->nisn ?? '-',
            $siswa->nama_lengkap ?? '-',
            $siswa->jenis_kelamin ?? '-',
            $siswa->tempat_lahir ?? '-',
            $siswa->tanggal_lahir
                ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y')
                : '-',
            $siswa->rombel->kelas->jurusan->nama ?? '-',
            $siswa->rombel->nama ?? '-',
            $siswa->tanggal_lulus
                ? \Carbon\Carbon::parse($siswa->tanggal_lulus)->format('Y')
                : '-',
            $siswa->tanggal_lulus
                ? \Carbon\Carbon::parse($siswa->tanggal_lulus)->format('d-m-Y')
                : '-',
            $siswa->status_kelulusan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}