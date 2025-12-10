@extends('layouts.app')

@section('title', 'Edit Rapor')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Edit Rapor — {{ $siswa->nama_lengkap }}</h3>
            <a href="{{ route('walikelas.nilai_raport.show', [
        'siswa_id' => $siswa->id,
        'semester' => $semester,
        'tahun' => $tahun
    ]) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('walikelas.nilai_raport.update', [
        'siswa_id' => $siswa->id,
        'semester' => $semester,
        'tahun' => $tahun
    ]) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Tambahkan input hidden untuk parameter -->
            <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
            <input type="hidden" name="semester" value="{{ $semester }}">
            <input type="hidden" name="tahun" value="{{ $tahun }}">
            <!-- Identitas Siswa -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Identitas Siswa</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Nama Peserta Didik</th>
                            <td>{{ $siswa->nama_lengkap }}</td>
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
                </div>
            </div>

            <!-- Kelompok A -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>A. Kelompok Mata Pelajaran Umum</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mata Pelajaran</th>
                                <th>Nilai Akhir</th>
                                <th>Capaian Kompetensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelompokA as $mapel)
                                <tr>
                                    <td>{{ $mapel->urutan }}</td>
                                    <td>{{ $mapel->nama }}</td>
                                    <td>
                                        <input type="number" name="nilai[{{ $mapel->id }}][nilai_akhir]" class="form-control"
                                            value="{{ $nilai[$mapel->id]->nilai_akhir ?? '' }}" min="0" max="100">
                                    </td>
                                    <td>
                                        <textarea name="nilai[{{ $mapel->id }}][deskripsi]" class="form-control"
                                            rows="2">{{ $nilai[$mapel->id]->deskripsi ?? '' }}</textarea>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Kelompok B -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>B. Kelompok Mata Pelajaran Kejuruan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mata Pelajaran</th>
                                <th>Nilai Akhir</th>
                                <th>Capaian Kompetensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelompokB as $mapel)
                                <tr>
                                    <td>{{ $mapel->urutan }}</td>
                                    <td>{{ $mapel->nama }}</td>
                                    <td>
                                        <input type="number" name="nilai[{{ $mapel->id }}][nilai_akhir]" class="form-control"
                                            value="{{ $nilai[$mapel->id]->nilai_akhir ?? '' }}" min="0" max="100">
                                    </td>
                                    <td>
                                        <textarea name="nilai[{{ $mapel->id }}][deskripsi]" class="form-control"
                                            rows="2">{{ $nilai[$mapel->id]->deskripsi ?? '' }}</textarea>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Ekstrakurikuler -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>C. Kegiatan Ekstrakurikuler</h5>
                </div>
                <div class="card-body">
                    <div id="ekstra-container">
                        @foreach($ekstra as $index => $e)
                            <div class="row mb-3 ekstra-row">
                                <div class="col-md-4">
                                    <input type="text" name="ekstra[{{ $index }}][nama_ekstra]" class="form-control"
                                        placeholder="Nama Ekstrakurikuler" value="{{ $e->nama_ekstra }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="ekstra[{{ $index }}][predikat]" class="form-control"
                                        placeholder="Predikat" value="{{ $e->predikat ?? '' }}">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="ekstra[{{ $index }}][keterangan]" class="form-control"
                                        placeholder="Keterangan" value="{{ $e->keterangan ?? '' }}">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm remove-ekstra">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-ekstra" class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> Tambah Ekstrakurikuler
                    </button>
                </div>
            </div>

            <!-- Kehadiran -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>D. Ketidakhadiran</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Sakit</label>
                            <input type="number" name="hadir[sakit]" class="form-control"
                                value="{{ $kehadiran->sakit ?? 0 }}" min="0">
                        </div>
                        <div class="col-md-4">
                            <label>Izin</label>
                            <input type="number" name="hadir[izin]" class="form-control" value="{{ $kehadiran->izin ?? 0 }}"
                                min="0">
                        </div>
                        <div class="col-md-4">
                            <label>Tanpa Keterangan</label>
                            <input type="number" name="hadir[alpa]" class="form-control"
                                value="{{ $kehadiran->tanpa_keterangan ?? 0 }}" min="0">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kenaikan Kelas -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>E. Kenaikan Kelas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Status</label>
                            <select name="kenaikan[status]" class="form-control">
                                <option value="Naik Kelas" {{ $kenaikan->status == 'Naik Kelas' ? 'selected' : '' }}>Naik</option>
                                <option value="Tidak Naik" {{ $kenaikan->status == 'Tidak Naik' ? 'selected' : '' }}>Tidak Naik
                                <option value="Lulus" {{ $kenaikan->status == 'Lulus' ? 'selected' : '' }}>Lulus
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Ke Kelas</label>
                            <select name="kenaikan[rombel_tujuan_id]" class="form-control">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($rombels as $rombel)
                                    <option value="{{ $rombel->id }}" {{ $kenaikan->rombel_tujuan_id == $rombel->id ? 'selected' : '' }}>
                                        {{ $rombel->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label>Catatan</label>
                        <textarea name="kenaikan[catatan]" class="form-control"
                            rows="2">{{ $kenaikan->catatan ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Info Rapor -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Informasi Rapor</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Wali Kelas</label>
                            <input type="text" name="info[wali_kelas]" class="form-control"
                                value="{{ $info->wali_kelas ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label>NIP Wali Kelas</label>
                            <input type="text" name="info[nip_wali]" class="form-control"
                                value="{{ $info->nip_wali ?? '' }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label>Kepala Sekolah</label>
                            <input type="text" name="info[kepsek]" class="form-control"
                                value="{{ $info->kepala_sekolah ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label>NIP Kepala Sekolah</label>
                            <input type="text" name="info[nip_kepsek]" class="form-control"
                                value="{{ $info->nip_kepsek ?? '' }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label>Tanggal Rapor</label>
                            <input type="date" name="info[tanggal_rapor]" class="form-control"
                                value="{{ $info->tanggal_rapor ?? date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tambah ekstrakurikuler
            document.getElementById('add-ekstra').addEventListener('click', function () {
                const container = document.getElementById('ekstra-container');
                const index = container.children.length;

                const newRow = document.createElement('div');
                newRow.className = 'row mb-3 ekstra-row';
                newRow.innerHTML = `
                <div class="col-md-4">
                    <input type="text" name="ekstra[${index}][nama_ekstra]" 
                           class="form-control" 
                           placeholder="Nama Ekstrakurikuler">
                </div>
                <div class="col-md-2">
                    <input type="text" name="ekstra[${index}][predikat]" 
                           class="form-control" 
                           placeholder="Predikat">
                </div>
                <div class="col-md-5">
                    <input type="text" name="ekstra[${index}][keterangan]" 
                           class="form-control" 
                           placeholder="Keterangan">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-ekstra">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;

                container.appendChild(newRow);
            });

            // Hapus ekstrakurikuler
            document.addEventListener('click', function (e) {
                if (e.target.closest('.remove-ekstra')) {
                    e.target.closest('.ekstra-row').remove();
                }
            });
        });
    </script>
@endpush