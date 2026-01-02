@extends('layouts.app')

@section('title', 'Input Nilai Rapor')

@section('content')
<div class="container mt-4">
    <h3>Input Nilai Rapor - {{ $siswa->nama_lengkap }}</h3>

    <form method="POST" action="{{ route('rapor.simpan.nilai', $siswa->id) }}">
        @csrf

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Semester</label>
                <input type="text" name="semester" class="form-control" value="{{ old('semester') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tahun Ajaran (contoh: 2024/2025)</label>
                <input type="text" name="tahun_ajaran" class="form-control" value="{{ old('tahun_ajaran') }}" required>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mata Pelajaran</th>
                            <th>Nilai Akhir</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mapel as $m)
                            <tr>
                                <td>{{ $m->urutan ?? $loop->iteration }}</td>
                                <td>{{ $m->nama }}</td>
                                <td>
                                    <input type="number" name="nilai[{{ $m->id }}]" class="form-control" min="0" max="100" value="{{ old('nilai.'.$m->id) }}">
                                </td>
                                <td>
                                    <textarea name="deskripsi[{{ $m->id }}]" class="form-control" rows="2">{{ old('deskripsi.'.$m->id) }}</textarea>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-end">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Nilai</button>
        </div>
    </form>
</div>
@endsection
