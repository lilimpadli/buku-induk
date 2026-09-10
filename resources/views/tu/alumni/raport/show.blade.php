@extends('layouts.app')

@section('title', 'Rapor - ' . ($siswa->nama_lengkap ?? 'Siswa'))

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h3>
            <i class="fas fa-file-alt text-primary"></i> Review Rapor
        </h3>
        <div class="d-flex gap-2">
            <a href="{{ route('tu.alumni.raport.list', $siswa->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('tu.alumni.raport.cetak', [
                'siswa_id' => $siswa->id,
                'semester' => $semester,
                'tahun' => str_replace('/', '-', $tahun)
            ]) }}" target="_blank" class="btn btn-primary">
                <i class="fas fa-print"></i> Cetak PDF
            </a>
        </div>
    </div>

    <!-- Identitas -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <table class="table table-bordered mb-0" style="font-size: 14px;">
                <tr>
                    <th style="width: 20%;">Nama Peserta Didik</th>
                    <td style="width: 30%;">{{ strtoupper($siswa->nama_lengkap ?? '-') }}</td>
                    <th style="width: 20%;">Kelas</th>
                    <td style="width: 30%;">
                        {{ $nilaiRaports->first()?->rombel?->nama ?? ($kelasHistory ? 'Kelas ' . $kelasHistory->tingkat . ' ' . ($kelasHistory->jurusan->nama ?? '') : '-') }}
                    </td>
                </tr>
                <tr>
                    <th>NISN</th>
                    <td>{{ $siswa->nisn ?? '-' }}</td>
                    <th>Semester</th>
                    <td>{{ $semester ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Sekolah</th>
                    <td>SMK NEGERI 1 KAWALI</td>
                    <th>Tahun Pelajaran</th>
                    <td>{{ $tahun ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Kelompok A -->
    <h5 class="fw-bold mb-3">A. Kelompok Mata Pelajaran Umum</h5>
    <div class="card shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0" style="font-size: 13px;">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 45%;">Mata Pelajaran</th>
                            <th style="width: 15%;" class="text-center">Nilai Akhir</th>
                            <th style="width: 35%;">Capaian Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $groupA = $nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'A'); @endphp
                        @if($groupA->isEmpty())
                            <tr><td colspan="4" class="text-center text-muted">Tidak ada data</td></tr>
                        @else
                            @foreach($groupA as $n)
                                <tr>
                                    <td class="text-center">{{ $n->mapel->urutan ?? '-' }}</td>
                                    <td>{{ $n->mapel->nama ?? '-' }}</td>
                                    <td class="text-center">{{ $n->nilai_akhir ?? '-' }}</td>
                                    <td>{{ $n->deskripsi ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kelompok B -->
    <h5 class="fw-bold mb-3">B. Kelompok Mata Pelajaran Kejuruan</h5>
    <div class="card shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0" style="font-size: 13px;">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 45%;">Mata Pelajaran</th>
                            <th style="width: 15%;" class="text-center">Nilai Akhir</th>
                            <th style="width: 35%;">Capaian Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $groupB = $nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'B'); @endphp
                        @if($groupB->isEmpty())
                            <tr><td colspan="4" class="text-center text-muted">Tidak ada data</td></tr>
                        @else
                            @foreach($groupB as $n)
                                <tr>
                                    <td class="text-center">{{ $n->mapel->urutan ?? '-' }}</td>
                                    <td>{{ $n->mapel->nama ?? '-' }}</td>
                                    <td class="text-center">{{ $n->nilai_akhir ?? '-' }}</td>
                                    <td>{{ $n->deskripsi ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Ekstrakurikuler -->
    <h5 class="fw-bold mb-3">C. Kegiatan Ekstrakurikuler</h5>
    <div class="card shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0" style="font-size: 13px;">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 45%;">Nama Ekstrakurikuler</th>
                            <th style="width: 20%;" class="text-center">Predikat</th>
                            <th style="width: 30%;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ekstra as $i => $e)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $e->nama_ekstra ?? '-' }}</td>
                                <td class="text-center">{{ $e->predikat ?? '-' }}</td>
                                <td>{{ $e->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kehadiran -->
    <h5 class="fw-bold mb-3">D. Ketidakhadiran</h5>
    <div class="card shadow-sm mb-4" style="max-width: 500px;">
        <div class="card-body">
            <table class="table table-bordered mb-0" style="font-size: 13px;">
                <tr>
                    <th style="width: 50%;">Sakit</th>
                    <td class="text-center">{{ $kehadiran->sakit ?? 0 }} hari</td>
                </tr>
                <tr>
                    <th>Izin</th>
                    <td class="text-center">{{ $kehadiran->izin ?? 0 }} hari</td>
                </tr>
                <tr>
                    <th>Tanpa Keterangan</th>
                    <td class="text-center">{{ $kehadiran->tanpa_keterangan ?? 0 }} hari</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Kenaikan Kelas -->
    @if(strtolower($semester ?? '') !== 'ganjil')
        <h5 class="fw-bold mb-3">E. Kenaikan Kelas</h5>
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <p><strong>Status:</strong> {{ $kenaikan->status ?? 'Belum Ditentukan' }}</p>
                @if(isset($kenaikan->rombelTujuan))
                    <p><strong>Ke Kelas:</strong> {{ $kenaikan->rombelTujuan->nama ?? '-' }}</p>
                @endif
                <p><strong>Catatan:</strong> {{ $kenaikan->catatan ?? '-' }}</p>
            </div>
        </div>
    @endif

</div>
@endsection