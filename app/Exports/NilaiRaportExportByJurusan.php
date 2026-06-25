<?php

namespace App\Exports;

use App\Models\NilaiRaport;
use App\Models\DataSiswa;
use App\Models\MataPelajaran;
use App\Models\Jurusan;
use App\Models\Kehadiran;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class NilaiRaportExportByJurusan implements FromArray, WithStyles, WithColumnWidths
{
    protected $jurusanId;
    protected $search;
    protected $semester;
    protected $tahunAjaran;

    public function __construct($jurusanId = null, $search = null, $semester = null, $tahunAjaran = null)
    {
        $this->jurusanId = $jurusanId;
        $this->search = $search;
        $this->semester = $semester;
        $this->tahunAjaran = $tahunAjaran;
    }

    public function array(): array
    {
        // Get students filtered by jurusan
        $query = DataSiswa::with(['rombel', 'nilaiRaports'])
            ->when($this->jurusanId, function ($q) {
                $q->whereHas('rombel.kelas', function ($qq) {
                    $qq->where('jurusan_id', $this->jurusanId);
                });
            });

        if ($this->search) {
            $like = '%' . $this->search . '%';
            $query->where(function($q) use ($like) {
                $q->where('nama_lengkap', 'like', $like)
                    ->orWhere('nis', 'like', $like)
                    ->orWhere('nisn', 'like', $like);
            });
        }

        $siswas = $query->orderBy('nama_lengkap')->get();

        if ($siswas->isEmpty()) {
            return [['Tidak ada data siswa']];
        }

        // Determine mapel list for jurusan
        if ($this->jurusanId) {
            $jurusan = Jurusan::find($this->jurusanId);
            $mapelList = $jurusan ? $jurusan->mataPelajarans()->orderBy('urutan')->get()->toArray() : [];
        } else {
            // Fallback: collect unique mapel from nilaiRaports across students
            $nilaiRaports = NilaiRaport::whereIn('siswa_id', $siswas->pluck('id'))
                ->when($this->semester, fn($q) => $q->where('semester', $this->semester))
                ->when($this->tahunAjaran, fn($q) => $q->where('tahun_ajaran', $this->tahunAjaran))
                ->with('mapel')
                ->get();

            $mapelList = [];
            if ($nilaiRaports->isNotEmpty()) {
                $mapelList = $nilaiRaports->pluck('mapel')
                    ->filter(fn($m) => $m !== null)
                    ->unique('id')
                    ->sortBy('urutan')
                    ->values()
                    ->toArray();
            }
        }

        $data = [];
        $data[] = ['Sekolah: SMKN 1 KAWALI'];
        $data[] = ['NPSN: 20233694'];
        $data[] = [];
        $data[] = ['LEDGER NILAI RAPORT'];
        $data[] = [];

        $data[] = ['Jurusan:', $jurusan->nama ?? ($this->jurusanId ? 'Terpilih' : 'Semua')];
        $data[] = ['Semester:', $this->semester ?? 'Semua'];
        $data[] = ['Tahun Ajaran:', $this->tahunAjaran ?? 'Semua'];
        $data[] = [];

        $headerRow = ['NO', 'NISN', 'NIS', 'NAMA SISWA'];
        foreach ($mapelList as $mapel) {
            $mapelObj = is_object($mapel) ? $mapel : (object)$mapel;
            $headerRow[] = strtoupper(substr($mapelObj->nama ?? 'MAPEL', 0, 10));
        }
        $headerRow[] = 'SAKIT';
        $headerRow[] = 'IZIN';
        $headerRow[] = 'ALPA';

        $data[] = $headerRow;

        $no = 1;

        // Index nilai by siswa_id and mapel
        $nilaiRaports = NilaiRaport::whereIn('siswa_id', $siswas->pluck('id'))
            ->when($this->semester, fn($q) => $q->where('semester', $this->semester))
            ->when($this->tahunAjaran, fn($q) => $q->where('tahun_ajaran', $this->tahunAjaran))
            ->with('mapel')
            ->get();

        $nilaiByStudentAndMapel = [];
        foreach ($nilaiRaports as $nilai) {
            $key = $nilai->siswa_id . '_' . $nilai->mata_pelajaran_id;
            $nilaiByStudentAndMapel[$key] = $nilai->nilai_akhir ?? 0;
        }

        foreach ($siswas as $siswa) {
            $row = [$no, $siswa->nisn, $siswa->nis, $siswa->nama_lengkap];

            $totalNilai = 0;
            $countNilai = 0;

            foreach ($mapelList as $mapel) {
                $mapelObj = is_object($mapel) ? $mapel : (object)$mapel;
                $mapelId = $mapelObj->id ?? null;

                $key = $siswa->id . '_' . $mapelId;
                if (isset($nilaiByStudentAndMapel[$key])) {
                    $nilaiValue = $nilaiByStudentAndMapel[$key];
                    $row[] = $nilaiValue;
                    $totalNilai += $nilaiValue;
                    $countNilai++;
                } else {
                    $row[] = '';
                }
            }

            $kehadiran = Kehadiran::where('siswa_id', $siswa->id)
                ->when($this->semester, fn($q) => $q->where('semester', $this->semester))
                ->when($this->tahunAjaran, fn($q) => $q->where('tahun_ajaran', $this->tahunAjaran))
                ->first();

            $row[] = $kehadiran->sakit ?? 0;
            $row[] = $kehadiran->izin ?? 0;
            $row[] = $kehadiran->alpa ?? 0;

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
        $sheet->getRowDimension(4)->setRowHeight(25);
        $sheet->freezePane('A13');
        return [];
    }
}
