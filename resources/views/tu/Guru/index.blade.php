@extends('layouts.app')

@section('title', 'Daftar Guru')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Guru</h3>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>NIP</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gurus as $g)
                            <tr>
                                <td>{{ $loop->iteration + ($gurus->currentPage()-1) * $gurus->perPage() }}</td>
                                <td>{{ $g->nama }}</td>
                                <td>{{ optional($g->user)->nomor_induk }}</td>
                                <td>{{ $g->nip }}</td>
                                <td>{{ $g->email }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">Belum ada guru</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $gurus->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
