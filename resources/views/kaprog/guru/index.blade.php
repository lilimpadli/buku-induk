@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Guru - Jurusan: {{ $jurusan->nama }}</h3>

    <div class="row mt-3">
        @forelse($gurus as $g)
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">

                        <h5 class="card-title mb-1">
                            {{ $g->nama }}
                            <small class="text-muted">({{ $g->nip }})</small>
                        </h5>

                        <p class="card-text mb-2">
                            {{ $g->email }} <br>
                            @if(optional($g->user)->role)
                                <small class="text-muted">
                                    Role: {{ $g->user->role }}
                                </small>
                            @endif
                        </p>

                        <p class="mb-1 fw-semibold">
                            Rombel yang diampu (jurusan ini):
                        </p>

                        @php
                            $rombelList = $g->rombels
                                ->filter(fn ($r) => optional($r->kelas)->jurusan_id == $jurusan->id);
                        @endphp

                        <ul class="mb-3">
                            @forelse($rombelList as $r)
                                <li>
                                    <strong>{{ $r->nama }}</strong>
                                    — Kelas {{ optional($r->kelas)->tingkat ?? '-' }}

                                    <br>
                                    <small class="text-muted">
                                        Jumlah siswa: {{ $r->siswa_count ?? ($r->siswa->count() ?? 0) }}
                                    </small>
                                </li>
                            @empty
                                <li class="text-muted">
                                    <em>Tidak ada rombel yang diampu.</em>
                                </li>
                            @endforelse
                        </ul>

                        <a href="{{ route('kaprog.guru.show', $g->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            Detail Guru
                        </a>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Belum ada guru di jurusan ini.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
