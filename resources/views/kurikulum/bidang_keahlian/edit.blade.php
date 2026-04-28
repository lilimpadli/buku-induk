@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Edit Bidang Keahlian</h1>
    <form action="{{ route('kurikulum.bidang-keahlian.update', $bidang->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_keahlian" class="form-label">Nama Keahlian</label>
            <input type="text" name="nama_keahlian" class="form-control" value="{{ $bidang->nama_keahlian }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('kurikulum.bidang-keahlian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
