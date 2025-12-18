@extends('layouts.app')

@section('title','PPDB - Assign Rombel')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body">
                <h4>{{ $entry->nama_lengkap }}</h4>
                <p class="text-muted">NISN: {{ $entry->nisn ?? '-' }}</p>

                <div class="row">
                    <div class="col-md-6"><strong>Tempat, Tanggal Lahir</strong><div>{{ $entry->tempat_lahir }}, {{ $entry->tanggal_lahir }}</div></div>
                    <div class="col-md-6"><strong>Jenis Kelamin</strong><div>{{ $entry->jenis_kelamin }}</div></div>
                </div>

                <hr>
                <h6>Alamat</h6>
                <p>{{ $entry->alamat ?? '-' }}</p>

                <hr>
                <h6>Dokumen</h6>
                <ul>
                    <li>KK: {{ $entry->kk ? 'Ada' : 'Tidak' }}</li>
                    <li>Akta: {{ $entry->akta ? 'Ada' : 'Tidak' }}</li>
                    <li>Ijazah: {{ $entry->ijazah ? 'Ada' : 'Tidak' }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Assign ke Rombel</h5>

                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('tu.ppdb.assign', $entry->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Pilih Rombel</label>
                        <select name="rombel_id" class="form-select">
                            <option value="">-- Pilih Rombel --</option>
                            @foreach($rombels as $r)
                                <option value="{{ $r->id }}">{{ $r->nama }} @if($r->kelas) ({{ $r->kelas->tingkat }}) @endif</option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-primary w-100">Simpan & Buat NIS</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
