@extends('layouts.app')

@section('title', 'Input Nilai Raport')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3>Input nilai raport: {{ $siswa->nama_lengkap }}</h3>
            <p>Kelas: {{ $siswa->kelas }} | Tahun Ajaran: {{ date('Y') }}/{{ date('Y')+1 }}</p>
        </div>
        <div>
            <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama_lengkap) }}&size=40&background=0D8ABC&color=fff" 
                 class="rounded-circle" alt="Avatar">
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('walikelas.input_nilai_raport.store', $siswa->id) }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Semester</label>
                        <select name="semester" class="form-select" required>
                            <option value="">-- Pilih Semester --</option>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" class="form-control" 
                               value="{{ date('Y') }}/{{ date('Y')+1 }}" required>
                    </div>
                </div>

                <h5 class="mb-3 fw-semibold">Formulir Input Nilai Raport</h5>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>KKM</th>
                                <th>Nilai Akhir</th>
                                <th>Predikat</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mataPelajaran as $mapel)
                                <tr>
                                    <td>
                                        <input type="hidden" name="nilai[{{ $loop->index }}][mata_pelajaran_id]" value="{{ $mapel->id }}">
                                        {{ $mapel->nama }}
                                    </td>
                                    <td>{{ $mapel->kkm }}</td>
                                    <td>
                                        <input type="number" name="nilai[{{ $loop->index }}][nilai_akhir]" 
                                               class="form-control" min="0" max="100" required>
                                    </td>
                                    <td>
                                        <input type="text" name="nilai[{{ $loop->index }}][predikat]" 
                                               class="form-control" required>
                                    </td>
                                    <td>
                                        <textarea name="nilai[{{ $loop->index }}][deskripsi]" 
                                                  class="form-control" rows="1" required></textarea>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('walikelas.input_nilai_raport.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection