@extends('layouts.app')

@section('title', 'Edit Rapor')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4">Edit Rapor — {{ $siswa->nama_lengkap }}</h3>
    <p class="text-muted">Semester {{ $semester }} — Tahun Ajaran {{ $tahun }}</p>

    <form action="{{ route('walikelas.input_nilai_raport.store', $siswa->id) }}" method="POST">
        @csrf

        {{-- ================== SEMESTER & TAHUN ================== --}}
        <input type="hidden" name="semester" value="{{ $semester }}">
        <input type="hidden" name="tahun_ajaran" value="{{ $tahun }}">

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
                @php
                    $nilaiMapel = $nilai[$m->id] ?? null;
                @endphp

                <tr>
                    <td class="text-center">{{ $m->urutan }}</td>
                    <td>{{ $m->nama }}</td>

                    <td>
                        <input type="number"
                               name="nilai[{{ $m->id }}][nilai_akhir]"
                               min="0" max="100"
                               value="{{ $nilaiMapel->nilai_akhir ?? '' }}"
                               class="form-control">
                    </td>

                    <td>
                        <textarea name="nilai[{{ $m->id }}][deskripsi]"
                                  rows="2"
                                  class="form-control">{{ $nilaiMapel->deskripsi ?? '' }}</textarea>
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
                @php
                    $nilaiMapel = $nilai[$m->id] ?? null;
                @endphp

                <tr>
                    <td class="text-center">{{ $m->urutan }}</td>
                    <td>{{ $m->nama }}</td>

                    <td>
                        <input type="number"
                               name="nilai[{{ $m->id }}][nilai_akhir]"
                               min="0" max="100"
                               value="{{ $nilaiMapel->nilai_akhir ?? '' }}"
                               class="form-control">
                    </td>

                    <td>
                        <textarea name="nilai[{{ $m->id }}][deskripsi]"
                                  rows="2"
                                  class="form-control">{{ $nilaiMapel->deskripsi ?? '' }}</textarea>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ================== EKSTRA ================== --}}
        <h5 class="mt-4 text-success">C. Kegiatan Ekstrakurikuler</h5>

        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Ekstrakurikuler</th>
                    <th>Predikat</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 0; @endphp
                @forelse($ekstra as $e)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>

                    <td>
                        <input type="text"
                               class="form-control"
                               name="ekstra[{{ $i }}][nama_ekstra]"
                               value="{{ $e->nama_ekstra }}">
                    </td>

                    <td>
                        <input type="text"
                               class="form-control"
                               name="ekstra[{{ $i }}][predikat]"
                               value="{{ $e->predikat }}">
                    </td>

                    <td>
                        <textarea name="ekstra[{{ $i }}][keterangan]"
                                  class="form-control"
                                  rows="2">{{ $e->keterangan }}</textarea>
                    </td>
                </tr>
                @php $i++; @endphp
                @empty
                <tr>
                    <td class="text-center">1</td>
                    <td><input type="text" class="form-control" name="ekstra[0][nama_ekstra]"></td>
                    <td><input type="text" class="form-control" name="ekstra[0][predikat]"></td>
                    <td><textarea class="form-control" name="ekstra[0][keterangan]"></textarea></td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- ================== KEHADIRAN ================== --}}
        <h5 class="mt-4 text-warning">D. Ketidakhadiran</h5>

        <div class="row">
            <div class="col-md-3">
                <label>Sakit</label>
                <input type="number" class="form-control"
                       name="hadir[sakit]"
                       value="{{ $kehadiran->sakit ?? 0 }}">
            </div>

            <div class="col-md-3">
                <label>Izin</label>
                <input type="number" class="form-control"
                       name="hadir[izin]"
                       value="{{ $kehadiran->izin ?? 0 }}">
            </div>

            <div class="col-md-3">
                <label>Tanpa Keterangan</label>
                <input type="number" class="form-control"
                       name="hadir[alpa]"
                       value="{{ $kehadiran->tanpa_keterangan ?? 0 }}">
            </div>
        </div>

        {{-- ================== KENAIKAN KELAS ================== --}}
        <h5 class="mt-4 text-danger">E. Kenaikan Kelas</h5>

        <div class="row mt-2">

            <div class="col-md-3">
                <label>Status</label>
                <select class="form-control" name="kenaikan[status]">
                    <option value="Naik Kelas" {{ ($kenaikan->status ?? '') == 'Naik Kelas' ? 'selected' : '' }}>Naik Kelas</option>
                    <option value="Tidak Naik" {{ ($kenaikan->status ?? '') == 'Tidak Naik' ? 'selected' : '' }}>Tidak Naik</option>
                    <option value="Lulus" {{ ($kenaikan->status ?? '') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                </select>
            </div>

            <div class="col-md-4">
                <label>Rombel Tujuan</label>
                <select class="form-control" name="kenaikan[rombel_tujuan_id]">
                    <option value="">-- Pilih Rombel --</option>
                    @foreach($rombels as $r)
                    <option value="{{ $r->id }}"
                        {{ ($kenaikan->rombel_tujuan_id ?? '') == $r->id ? 'selected' : '' }}>
                        {{ $r->nama }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5">
                <label>Catatan</label>
                <textarea name="kenaikan[catatan]" class="form-control" rows="2">{{ $kenaikan->catatan ?? '' }}</textarea>
            </div>

        </div>

        {{-- ================== INFO RAPOR ================== --}}
        <h5 class="mt-4 text-info">F. Info Rapor</h5>

        <div class="row">

            <div class="col-md-4">
                <label>Wali Kelas</label>
                <input type="text" name="info[wali_kelas]"
                       class="form-control"
                       value="{{ $info->wali_kelas ?? '' }}">
            </div>

            <div class="col-md-4">
                <label>NIP Wali Kelas</label>
                <input type="text" name="info[nip_wali]"
                       class="form-control"
                       value="{{ $info->nip_wali ?? '' }}">
            </div>

            <div class="col-md-4">
                <label>Kepala Sekolah</label>
                <input type="text" name="info[kepsek]"
                       class="form-control"
                       value="{{ $info->kepala_sekolah ?? '' }}">
            </div>

            <div class="col-md-4 mt-3">
                <label>NIP Kepala Sekolah</label>
                <input type="text" name="info[nip_kepsek]"
                       class="form-control"
                       value="{{ $info->nip_kepsek ?? '' }}">
            </div>

            <div class="col-md-4 mt-3">
                <label>Tanggal Rapor</label>
                <input type="date" name="info[tanggal_rapor]"
                       class="form-control"
                       value="{{ $info->tanggal_rapor ?? '' }}">
            </div>

        </div>

        <button class="btn btn-success mt-4">Update Rapor</button>

    </form>

</div>
@endsection
