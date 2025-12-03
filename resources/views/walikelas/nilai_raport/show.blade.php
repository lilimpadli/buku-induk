@extends('layouts.app')

@section('title', 'Raport Siswa')

@section('content')
<div class="container mt-4 mb-4">

    <!-- TOMBOL EXPORT PDF -->
    <a href="{{ route('walikelas.nilai_raport.pdf', $siswa->id) }}" 
       class="btn btn-danger mb-3"
       target="_blank">
        <i class="fas fa-file-pdf me-1"></i> Export PDF
    </a>

    <!-- HEADER IDENTITAS -->
    <div class="card shadow mb-4">
        <div class="card-body">

            <table class="table table-borderless mb-0">
                <tr>
                    <th width="25%">Nama Peserta Didik</th>
                    <td>: {{ $siswa->nama_lengkap }}</td>
                </tr>
                <tr>
                    <th>Nomor Induk / NISN</th>
                    <td>: {{ $siswa->nis }} / {{ $siswa->nisn }}</td>
                </tr>
                <tr>
                    <th>Sekolah</th>
                    <td>: SMK NEGERI 1 KAWALI</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>: JL. TALAGASARI NO. 35</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>: {{ $siswa->kelas }}</td>
                </tr>
                <tr>
                    <th>Semester</th>
                    <td>: {{ $nilaiRaports->first()->semester ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tahun Pelajaran</th>
                    <td>: {{ $nilaiRaports->first()->tahun_ajaran ?? '-' }}</td>
                </tr>
            </table>

        </div>
    </div>

    <!-- NILAI AKADEMIK -->
    <div class="card shadow">
        <div class="card-body">
            
            <h5 class="fw-bold">A. Nilai Akademik</h5>

            <p class="fw-semibold mt-3">A. Kelompok Mata Pelajaran Umum</p>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">

                    <thead class="table-light text-center">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 220px;">Mata Pelajaran</th>
                            <th style="width: 120px;">Nilai Akhir</th>
                            <th>Capaian Kompetensi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($nilaiRaports as $index => $nilai)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $nilai->mata_pelajaran }}</td>
                                <td class="text-center fw-bold">{{ $nilai->nilai_pengetahuan }}</td>
                                <td>{{ $nilai->deskripsi_pengetahuan }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <p class="fw-semibold mt-4">B. Kelompok Mata Pelajaran Kejuruan</p>
            <p class="text-muted">*Masukkan mata pelajaran kejuruan di sini jika ada.</p>
        </div>
    </div>

    <div class="text-center mt-4 text-muted">
        <small>Dicetak dari e-Raport SMK</small>
    </div>

</div>
@endsection
