@extends('layouts.app')

@section('title', 'Input Nilai Raport')

@section('content')
<div class="container mt-4 mb-4">

    <!-- HEADER SISWA -->
    <div class="card shadow mb-4">
        <div class="card-body p-4">
            <table class="table table-borderless mb-0">
                <tr>
                    <th width="35%">Nama Peserta Didik</th>
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

                <!-- FORM SEMESTER & TAHUN AJARAN -->
                <tr>
                    <th>Semester</th>
                    <td>
                        <select name="semester" form="formNilai" class="form-control" required>
                            <option value="">-- Pilih Semester --</option>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>Tahun Ajaran</th>
                    <td>
                        <input type="text" name="tahun_ajaran" form="formNilai"
                               class="form-control" placeholder="2024/2025" required>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- FORM INPUT NILAI -->
    <form id="formNilai" action="{{ route('walikelas.input_nilai_raport.store', $siswa->id) }}" method="POST">
        @csrf

        <div class="card shadow">
            <div class="card-body p-4">

                <h5 class="fw-bold mb-3">A. NILAI AKADEMIK</h5>

                <p class="fw-semibold mb-1">A. Kelompok Mata Pelajaran Umum</p>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle">

                        <thead class="table-light text-center align-middle">
                            <tr style="font-weight: bold;">
                                <th style="width: 40px;">No</th>
                                <th style="width: 220px;">Mata Pelajaran</th>
                                <th style="width: 80px;">Nilai Akhir</th>
                                <th>Capaian Kompetensi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($mataPelajaran as $index => $mapel)
                                <tr>
                                    <td class="text-center fw-bold">{{ $index + 1 }}</td>

                                    <td>
                                        <input type="hidden" name="nilai[{{ $index }}][mata_pelajaran]" value="{{ $mapel->nama }}">
                                        {{ $mapel->nama }}
                                    </td>

                                    <td>
                                        <input type="number" name="nilai[{{ $index }}][nilai_pengetahuan]"
                                               class="form-control text-center"
                                               min="0" max="100" required>
                                    </td>

                                    <td>
                                        <textarea name="nilai[{{ $index }}][deskripsi_pengetahuan]"
                                                  class="form-control" rows="2" required></textarea>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                <div class="text-end mt-3">
                    <button class="btn btn-primary">Simpan Nilai Raport</button>
                </div>

            </div>
        </div>

    </form>

</div>
@endsection
