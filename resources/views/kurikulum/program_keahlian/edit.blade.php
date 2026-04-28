@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Edit Program Keahlian</h1>
    <form action="{{ route('kurikulum.program-keahlian.update', $jurusan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="kode" class="form-label">Kode</label>
            <input type="text" name="kode" class="form-control" value="{{ $jurusan->kode }}" required>
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $jurusan->nama }}" required>
        </div>
        <div class="mb-3">
            <label for="id_konsentrasi" class="form-label">Konsentrasi Keahlian</label>
            <select name="id_konsentrasi" class="form-control" required>
                <option value="">-- Pilih Konsentrasi --</option>
                @foreach($konsentrasi as $k)
                    <option value="{{ $k->id }}" @if($jurusan->id_konsentrasi == $k->id) selected @endif>{{ $k->nama_konsentrasi }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('kurikulum.program-keahlian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
