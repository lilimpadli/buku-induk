@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Tambah Program Keahlian</h1>
    <form action="{{ route('kurikulum.program-keahlian.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="kode" class="form-label">Kode</label>
            <input type="text" name="kode" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="id_konsentrasi" class="form-label">Konsentrasi Keahlian</label>
            <select name="id_konsentrasi" class="form-control" required>
                <option value="">-- Pilih Konsentrasi --</option>
                @foreach($konsentrasi as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_konsentrasi }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('kurikulum.program-keahlian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
