<?php

namespace App\Exports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GuruExport implements FromCollection, WithHeadings, WithMapping
{
    protected $search;
    protected $jurusan_id;

    public function __construct($search = null, $jurusan_id = null)
    {
        $this->search = $search;
        $this->jurusan_id = $jurusan_id;
    }

    public function collection()
    {
        $query = Guru::with(['user','rombels.kelas.jurusan'])->orderBy('nama');

        if (!empty($this->search)) {
            $s = $this->search;
            $query->where(function($q) use ($s) {
                $q->where('nama', 'like', "%{$s}%")
                  ->orWhere('nip', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%");
            });
        }

        if (!empty($this->jurusan_id)) {
            $query->where('jurusan_id', $this->jurusan_id);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return ['Nama', 'NIP', 'Email', 'Jurusan', 'Kelas / Rombel', 'Role'];
    }

    public function map($guru): array
    {
        $jurusan = $guru->jurusan?->nama ?? '';

        $rombels = $guru->rombels->map(function($r){
            $kelas = $r->kelas;
            $kelasText = $kelas?->tingkat ? ($kelas->tingkat . ' - ' . ($kelas->jurusan->nama ?? '')) : '';
            return trim($kelasText . ' / ' . $r->nama);
        })->implode('; ');

        return [
            $guru->nama,
            $guru->nip,
            $guru->email,
            $jurusan,
            $rombels,
            $guru->user?->role ?? '',
        ];
    }
}
