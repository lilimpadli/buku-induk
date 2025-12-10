@extends('layouts.app')

@section('title', 'Review Rapor')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Review Rapor</h3>
            <div>
                <a href="{{ route('walikelas.nilai_raport.list', $siswa->id) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('walikelas.rapor.cetak', [
        'siswa_id' => $siswa->id,
        'semester' => $semester,
        'tahun' => $tahun
    ]) }}" class="btn btn-primary" target="_blank">
                    Cetak PDF
                </a>
                <a href="{{ route('walikelas.nilai_raport.edit', [
        'siswa_id' => $siswa->id,
        'semester' => $semester,
        'tahun' => $tahun
    ]) }}" class="btn btn-warning">
                    Edit Rapor
                </a>
            </div>
        </div>

        {{-- Identitas --}}
        <table class="table table-bordered mb-4">
            <tr>
                <th width="30%">Nama Peserta Didik</th>
                <td>{{ strtoupper($siswa->nama_lengkap) }}</td>
                <th width="30%">Kelas</th>
                <td>{{ $siswa->rombel->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>NISN</th>
                <td>{{ $siswa->nisn }}</td>
                <th>Semester</th>
                <td>{{ $semester }}</td>
            </tr>
            <tr>
                <th>Sekolah</th>
                <td>SMK NEGERI 1 X</td>
                <th>Tahun Pelajaran</th>
                <td>{{ $tahun }}</td>
            </tr>
        </table>

        {{-- A. Kelompok A --}}
        <h5 class="fw-bold mt-4">A. Kelompok Mata Pelajaran Umum</h5>
        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Mata Pelajaran</th>
                    <th>Nilai Akhir</th>
                    <th>Capaian Kompetensi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'A') as $n)
                    <tr>
                        <td class="text-center">{{ $n->mapel->urutan }}</td>
                        <td>{{ $n->mapel->nama }}</td>
                        <td class="text-center">{{ $n->nilai_akhir }}</td>
                        <td>{{ $n->deskripsi }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- B. Kelompok B --}}
        <h5 class="fw-bold mt-4">B. Kelompok Mata Pelajaran Kejuruan</h5>
        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Mata Pelajaran</th>
                    <th>Nilai Akhir</th>
                    <th>Capaian Kompetensi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'B') as $n)
                    <tr>
                        <td class="text-center">{{ $n->mapel->urutan }}</td>
                        <td>{{ $n->mapel->nama }}</td>
                        <td class="text-center">{{ $n->nilai_akhir }}</td>
                        <td>{{ $n->deskripsi }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Ekstrakurikuler --}}
        <h5 class="fw-bold mt-4">C. Kegiatan Ekstrakurikuler</h5>
        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Ekstrakurikuler</th>
                    <th>Predikat</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ekstra as $i => $e)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $e->nama_ekstra }}</td>
                        <td class="text-center">{{ $e->predikat ?? '-' }}</td>
                        <td>{{ $e->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Kehadiran --}}
        <h5 class="fw-bold mt-4">D. Ketidakhadiran</h5>
        <table class="table table-bordered" style="width: 50%">
            <tr>
                <th>Sakit</th>
                <td>{{ $kehadiran->sakit ?? 0 }} hari</td>
            </tr>
            <tr>
                <th>Izin</th>
                <td>{{ $kehadiran->izin ?? 0 }} hari</td>
            </tr>
            <tr>
                <th>Tanpa Keterangan</th>
                <td>{{ $kehadiran->tanpa_keterangan ?? 0 }} hari</td>
            </tr>
        </table>

        {{-- Kenaikan --}}
        <h5 class="fw-bold mt-4">E. Kenaikan Kelas</h5>
        <p><b>Status:</b> {{ $kenaikan->status ?? 'Belum Ditentukan' }}</p>
        @if(isset($kenaikan->rombelTujuan))
            <p><b>Ke Kelas:</b> {{ $kenaikan->rombelTujuan->nama }}</p>
        @endif
        <p><b>Catatan:</b> {{ $kenaikan->catatan ?? '-' }}</p>

        {{-- Tanda tangan --}}
        <div class="row mt-5">
            <div class="col-md-6 text-center">
                <p>Wali Kelas</p>
                <br><br><br>
                <b>{{ $info->wali_kelas ?? '-' }}</b><br>
                NIP. {{ $info->nip_wali ?? '-' }}
            </div>
            <div class="col-md-6 text-center">
                <p>Kepala Sekolah</p>
                <br><br><br>
                <b>{{ $info->kepala_sekolah ?? '-' }}</b><br>
                NIP. {{ $info->nip_kepsek ?? '-' }}
            </div>
        </div>
    </div>
@endsection