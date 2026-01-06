@extends('layouts.app')

@section('title', 'Data Kelulusan')

@section('content')
<div class="container py-3">
    <h3>Data Kelulusan per Tahun Ajaran</h3>

    @if($items->isEmpty())
        <p>Tidak ada data kelulusan.</p>
    @endif

    @foreach($items as $tahun => $group)
        <div class="card my-3">
            <div class="card-header">Tahun Ajaran: {{ $tahun }}</div>
            <div class="card-body">
                @php
                    $byJurusan = [];
                @endphp
                @foreach($group as $row)
                    @php
                        $jurusan = optional(optional(optional($row->rombelTujuan)->kelas)->jurusan)->nama ?? 'Tanpa Jurusan';
                        $rombel = optional($row->rombelTujuan)->nama ?? 'Tanpa Rombel';
                        $rombelId = $row->rombel_tujuan_id ?? '0';
                        $key = $jurusan.'|'.$rombel.'|'.$rombelId;
                        $byJurusan[$key][] = $row;
                    @endphp
                @endforeach

                @foreach($byJurusan as $key => $rows)
                    @php
                        [$jurusanName, $rombelName, $rombelId] = explode('|', $key);
                    @endphp
                    <div class="mb-2">
                        <strong>{{ $jurusanName }}</strong> — Rombel: {{ $rombelName }}
                        <span class="badge bg-primary ms-2">{{ count($rows) }} siswa</span>
                        @if($rombelId != '0')
                            <a href="{{ route('tu.kelulusan.rombel.show', ['rombelId' => $rombelId, 'tahun' => rawurlencode($tahun)]) }}" class="btn btn-sm btn-outline-secondary ms-2">Lihat</a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection
