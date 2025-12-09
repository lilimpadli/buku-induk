@extends('layouts.app')

@section('title', 'Input Rapor')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4">Input Rapor — {{ $siswa->nama_lengkap }}</h3>

    <form action="{{ route('walikelas.input_nilai_raport.store', $siswa->id) }}" method="POST">
        @csrf

        {{-- ================== SEMESTER & TAHUN ================== --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <label class="fw-bold">Semester</label>
                <select name="semester" class="form-control" required>
                    <option value="Ganjil">Ganjil</option>
                    <option value="Genap">Genap</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="fw-bold">Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" placeholder="2024/2025"
                       class="form-control" required>
            </div>
        </div>

        {{-- ================== NILAI MAPEL KELOMPOK A ================== --}}
        <h5 class="mt-3 text-primary">A. Kelompok Mata Pelajaran Umum</h5>

        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th width="5%">No</th>
                    <th>Mata Pelajaran</th>
                    <th width="10%">Nilai Akhir</th>
                    <th>Capaian Kompetensi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kelompokA as $m)
                <tr>
                    <td class="text-center">{{ $m->urutan }}</td>
                    <td>{{ $m->nama }}</td>
                    <td>
                        <input type="number" name="nilai[{{ $m->id }}][nilai_akhir]"
                               min="0" max="100" class="form-control">
                    </td>
                    <td>
                        <textarea name="nilai[{{ $m->id }}][deskripsi]"
                                  rows="2" class="form-control"></textarea>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ================== NILAI MAPEL KELOMPOK B ================== --}}
        <h5 class="mt-3 text-primary">B. Kelompok Mata Pelajaran Kejuruan</h5>

        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th width="5%">No</th>
                    <th>Mata Pelajaran</th>
                    <th width="10%">Nilai Akhir</th>
                    <th>Capaian Kompetensi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kelompokB as $m)
                <tr>
                    <td class="text-center">{{ $m->urutan }}</td>
                    <td>{{ $m->nama }}</td>
                    <td>
                        <input type="number" name="nilai[{{ $m->id }}][nilai_akhir]"
                               min="0" max="100" class="form-control">
                    </td>
                    <td>
                        <textarea name="nilai[{{ $m->id }}][deskripsi]"
                                  rows="2" class="form-control"></textarea>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ================== EKSTRA ================== --}}
        <h5 class="mt-4 text-success">C. Catatan Ekstrakurikuler</h5>

        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Ekstrakurikuler</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 0; $i < 3; $i++)
                <tr>
                    <td class="text-center">{{ $i+1 }}</td>
                    <td>
                        <input type="text" name="ekstra[{{ $i }}][nama_ekstra]"
                               class="form-control" placeholder="Contoh: Pramuka">
                    </td>
                    <td>
                        <textarea name="ekstra[{{ $i }}][keterangan]"
                                  class="form-control" rows="2"></textarea>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>

        {{-- ================== KEHADIRAN ================== --}}
        <h5 class="mt-4 text-warning">D. Ketidakhadiran</h5>

        <div class="row">
            <div class="col-md-3">
                <label>Sakit</label>
                <input type="number" class="form-control" name="hadir[sakit]" min="0">
            </div>
            <div class="col-md-3">
                <label>Izin</label>
                <input type="number" class="form-control" name="hadir[izin]" min="0">
            </div>
            <div class="col-md-3">
                <label>Tanpa Keterangan</label>
                <input type="number" class="form-control" name="hadir[alpa]" min="0">
            </div>
        </div>

        {{-- ================== KENAIKAN KELAS ================== --}}
        <h5 class="mt-4 text-danger">E. Kenaikan Kelas</h5>

        <div class="row mt-2">
            <div class="col-md-3">
                <label>Status</label>
                <select class="form-control" name="kenaikan[status]">
                    <option value="Naik Kelas">Naik Kelas</option>
                    <option value="Tidak Naik">Tidak Naik</option>
                    <option value="Lulus">Lulus</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Ke Kelas</label>
                <input type="text" class="form-control"
                       name="kenaikan[ke_kelas]" placeholder="XI MM 1">
            </div>
        </div>

        {{-- ================== INFO RAPOR ================== --}}
        <h5 class="mt-4 text-info">F. Info Rapor</h5>

        <div class="row">
            <div class="col-md-4">
                <label>Wali Kelas</label>
                <input type="text" name="info[wali_kelas]" class="form-control">
            </div>

            <div class="col-md-4">
                <label>NIP Wali Kelas</label>
                <input type="text" name="info[nip_wali]" class="form-control">
            </div>

            <div class="col-md-4">
                <label>Kepala Sekolah</label>
                <input type="text" name="info[kepsek]" class="form-control">
            </div>

            <div class="col-md-4 mt-3">
                <label>NIP Kepala Sekolah</label>
                <input type="text" name="info[nip_kepsek]" class="form-control">
            </div>

            <div class="col-md-4 mt-3">
                <label>Tanggal Rapor</label>
                <input type="date" name="info[tanggal_rapor]" class="form-control">
            </div>
        </div>

        <button class="btn btn-success mt-4">Simpan Semua Data</button>

    </form>

</div>
@endsection
