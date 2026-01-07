@extends('layouts.app')

@section('title', 'PPDB Timeline')

@section('content')
<div class="container mt-4">
    <h3>PPDB Timeline — Atur Tanggal Tahap</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('kurikulum.ppdb.timeline.update') }}">
        @csrf

        <div class="card mb-3">
            <div class="card-header">Tahap 1</div>
            <div class="card-body">
                <div class="mb-2">
                    <label>Judul (ditampilkan)</label>
                    <input type="text" name="tahap1[title]" class="form-control" value="{{ $data['tahap1']['title'] ?? 'Pendaftaran Tahap 1' }}">
                </div>
                    <div class="mb-2">
                        <label>Status</label>
                        <select name="tahap1[open]" class="form-select">
                            <option value="1" {{ ($data['tahap1']['open'] ?? true) ? 'selected' : '' }}>Terbuka</option>
                            <option value="0" {{ !($data['tahap1']['open'] ?? true) ? 'selected' : '' }}>Tutup</option>
                        </select>
                    </div>
                @php
                    $presets = [
                        '10 - 16 Juni 2025',
                        '10-17 Juni 2025',
                        '18 Juni 2025',
                        '19 Juni 2025 (09:00 WIB)',
                        '20-23 Juni 2025',
                    ];

                    $fields1 = ['pendaftaran','sanggah','rapat','pengumuman','daftar_ulang'];
                @endphp

                @php
                    $rangeFields1 = ['pendaftaran','sanggah','daftar_ulang'];
                @endphp
                @foreach($fields1 as $f)
                    @php $val = $data['tahap1'][$f] ?? ''; $isRange = in_array($f, $rangeFields1, true); @endphp
                    <div class="mb-2">
                        <label>{{ ucfirst(str_replace('_',' ', $f)) }}</label>
                        <input type="text" name="tahap1[{{ $f }}]" class="form-control {{ $isRange ? 'flatpickr-range' : 'flatpickr-single' }}" placeholder="{{ $isRange ? 'Pilih rentang tanggal' : 'Pilih tanggal' }}" value="{{ $val }}">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Tahap 2</div>
            <div class="card-body">
                <div class="mb-2">
                    <label>Judul (ditampilkan)</label>
                    <input type="text" name="tahap2[title]" class="form-control" value="{{ $data['tahap2']['title'] ?? 'Pendaftaran Tahap 2' }}">
                </div>
                    <div class="mb-2">
                        <label>Status</label>
                        <select name="tahap2[open]" class="form-select">
                            <option value="1" {{ ($data['tahap2']['open'] ?? false) ? 'selected' : '' }}>Terbuka</option>
                            <option value="0" {{ !($data['tahap2']['open'] ?? false) ? 'selected' : '' }}>Tutup</option>
                        </select>
                    </div>
                @php
                    $presets2 = [
                        '24 Juni - 1 Juli 2025',
                        '24 Juni - 2 Juli 2025',
                        '2-7 Juli 2025',
                        '8 Juli 2025',
                        '9 Juli 2025 (15:00 WIB)',
                        '10-11 Juli 2025',
                    ];
                    $fields2 = ['pendaftaran','sanggah','tes','rapat','pengumuman','daftar_ulang'];
                @endphp

                @php
                    $rangeFields2 = ['pendaftaran','sanggah','tes','daftar_ulang'];
                @endphp
                @foreach($fields2 as $f)
                    @php $val = $data['tahap2'][$f] ?? ''; $isRange = in_array($f, $rangeFields2, true); @endphp
                    <div class="mb-2">
                        <label>{{ ucfirst(str_replace('_',' ', $f)) }}</label>
                        <input type="text" name="tahap2[{{ $f }}]" class="form-control {{ $isRange ? 'flatpickr-range' : 'flatpickr-single' }}" placeholder="{{ $isRange ? 'Pilih rentang tanggal' : 'Pilih tanggal' }}" value="{{ $val }}">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="text-end">
            <button class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    // Range pickers (mode: range) with human-friendly alt input
    document.querySelectorAll('.flatpickr-range').forEach(function(el){
        flatpickr(el, {
            mode: 'range',
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'j F Y',
            allowInput: true,
        });
    });

    // Single date pickers
    document.querySelectorAll('.flatpickr-single').forEach(function(el){
        flatpickr(el, {
            mode: 'single',
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'j F Y',
            allowInput: true,
        });
    });
});
</script>
@endpush
