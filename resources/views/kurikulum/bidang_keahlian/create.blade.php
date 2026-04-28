@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Tambah Bidang Keahlian</h1>
    <form action="{{ route('kurikulum.bidang-keahlian.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_keahlian" class="form-label">Nama Keahlian</label>
            <input type="text" name="nama_keahlian" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('kurikulum.bidang-keahlian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
