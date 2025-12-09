@extends('layouts.app')

@section('title', 'Review Rapor')

@section('content')
<div class="container mt-4">

    <h3 class="mb-3">Review Rapor — {{ $siswa->nama_lengkap }}</h3>

    <a href="{{ route('walikelas.nilai_raport.exportPdf', $siswa->id) }}"
       class="btn btn-primary mb-4">Cetak PDF</a>

    {{-- IDENTITAS --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Identitas Siswa</div>
        <div class="card-body">
            <p><b>Nama:</b> {{ $siswa->nama_lengkap }}</p>
            <p><b>NISN:</b> {{ $siswa->nisn }}</p>
            <p><b>Kelas:</b> {{ $siswa->kelas ?? '-' }}</p>
        </div>
    </div>

    {{-- NILAI --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Nilai Mata Pelajaran</div>
        <table class="table table-bordered">
            <thead>
                <tr class="text-center">
                    <th>Mata Pelajaran</th>
                    <th width="10%">Nilai</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nilaiRaports as $n)
                <tr>
                    <td>{{ $n->mata_pelajaran }}</td>
                    <td class="text-center">{{ $n->nilai_pengetahuan ?? $n->nilai_akhir }}</td>
                    <td>{{ $n->deskripsi_pengetahuan ?? $n->deskripsi }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- EKSTRA --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Ekstrakurikuler</div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th width="10%">Predikat</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ekstra as $e)
                <tr>
                    <td>{{ $e->nama_ekstra }}</td>
                    <td class="text-center">{{ $e->predikat }}</td>
                    <td>{{ $e->keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- KEHADIRAN --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Kehadiran</div>
        <div class="card-body">
            <p><b>Sakit:</b> {{ $kehadiran->sakit ?? 0 }}</p>
            <p><b>Izin:</b> {{ $kehadiran->izin ?? 0 }}</p>
            <p><b>Alpa:</b> {{ $kehadiran->tanpa_keterangan ?? 0 }}</p>
        </div>
    </div>

    {{-- KENAIKAN --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Kenaikan Kelas</div>
        <div class="card-body">
            <p><b>Status:</b> {{ $kenaikan->status ?? 'Belum Ditentukan' }}</p>
            <p><b>Catatan:</b> {{ $kenaikan->catatan ?? '-' }}</p>
        </div>
    </div>

</div>
@endsection
