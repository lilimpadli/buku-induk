@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Detail Guru: {{ $guru->nama }}</h3>

    <p>
        <strong>Email:</strong> {{ $guru->email }} <br>
        <strong>NIP:</strong> {{ $guru->nip }} <br>

        @if(optional($guru->user)->role)
            <strong>Role:</strong> {{ $guru->user->role }} <br>
        @endif

        @if(optional($guru->user)->name)
            <strong>Login Name:</strong> {{ $guru->user->name }}
        @endif
    </p>

    <hr>

    <h5 class="mt-3">
        Rombel yang diampu di jurusan {{ $jurusan->nama }}
    </h5>

    <table class="table table-bordered table-sm mt-3">
        <thead class="table-light">
            <tr>
                <th>Rombel</th>
                <th>Kelas</th>
                <th>Jumlah Siswa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rombels as $r)
                <tr>
                    <td>{{ $r->nama }}</td>

                    <td>
                        {{ optional($r->kelas)->tingkat ?? '-' }}
                        {{ optional(optional($r->kelas)->jurusan)->kode ?? '' }}
                    </td>

                    <td class="text-center">
                        {{ $r->siswa_count ?? 0 }}
                    </td>

                    <td class="text-center">
                        <a href="{{ route('kaprog.kelas.show', $r->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            Lihat Rombel
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        <em>Tidak ada rombel yang diampu.</em>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('kaprog.guru.index') }}" class="btn btn-secondary">
        ← Kembali
    </a>
</div>
@endsection
