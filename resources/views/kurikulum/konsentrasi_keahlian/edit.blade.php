@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Edit Konsentrasi Keahlian</h1>
    <form action="{{ route('kurikulum.konsentrasi-keahlian.update', $konsentrasi->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_konsentrasi" class="form-label">Nama Konsentrasi</label>
            <input type="text" name="nama_konsentrasi" class="form-control" value="{{ $konsentrasi->nama_konsentrasi }}" required>
        </div>
        <div class="mb-3">
            <label for="id_bidang" class="form-label">Bidang Keahlian</label>
            <select name="id_bidang" class="form-control" required>
                <option value="">-- Pilih Bidang --</option>
                @foreach($bidang as $b)
                    <option value="{{ $b->id }}" @if($konsentrasi->id_bidang == $b->id) selected @endif>{{ $b->nama_keahlian }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('kurikulum.konsentrasi-keahlian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
