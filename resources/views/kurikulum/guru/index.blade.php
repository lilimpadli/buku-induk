@extends('layouts.app')

@section('title', 'Daftar Guru per Jurusan')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Guru per Jurusan</h3>
        <a href="{{ route('kurikulum.guru.manage.create') }}" class="btn btn-primary">
            Tambah Guru
        </a>
    </div>

    <div class="row">
        @foreach($jurusans as $jurusan)
            @php
                $gurus = $jurusan->gurus ?? collect();
                $modalId = 'modal-jurusan-' . $jurusan->id;
            @endphp

            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            {{ $jurusan->nama }}

                            @if($gurus->count() == 0)
                                <span class="badge bg-warning text-dark">
                                    Belum ada guru
                                </span>
                            @endif
                        </h5>

                        <p class="mb-2">
                            Jumlah guru:
                            <strong>{{ $gurus->count() }}</strong>
                        </p>

                        <button
                            class="btn btn-sm btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#{{ $modalId }}"
                        >
                            Lihat Guru
                        </button>

                        <a href="{{ route('kurikulum.guru.manage.create') }}"
                           class="btn btn-sm btn-outline-secondary">
                            Tambah Guru
                        </a>
                    </div>
                </div>
            </div>

            <!-- MODAL -->
            <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">
                                Daftar Guru — {{ $jurusan->nama }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <!-- SEARCH -->
                            <input
                                type="text"
                                class="form-control mb-3 search-input"
                                placeholder="Cari nama / email / role"
                            >

                            <table class="table table-sm table-striped guru-table">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th width="25%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($gurus as $g)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $g->nama }}</td>
                                            <td>{{ $g->email }}</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $g->user->role ?? '-' }}
                                                </span>
                                            </td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-info btn-view"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#guruDetailModal"
                                                    data-nama="{{ $g->nama }}"
                                                    data-email="{{ $g->email }}"
                                                    data-role="{{ $g->user->role ?? '-' }}"
                                                    data-jurusan="{{ $g->jurusan->nama ?? '-' }}"
                                                    data-kelas="{{ optional($g->kelas)->tingkat ?? '-' }}"
                                                    title="Lihat">
                                                    <i class="fa fa-eye"></i>
                                                </button>

                                                <a href="{{ route('kurikulum.guru.manage.edit', $g->id) }}"
                                                   class="btn btn-sm btn-warning">
                                                    Edit
                                                </a>

                                                <form action="{{ route('kurikulum.guru.manage.destroy', $g->id) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Hapus guru ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">
                                                Belum ada guru di jurusan ini
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">
                                Tutup
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Guru detail modal (reusable) -->
    <div class="modal fade" id="guruDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <dl class="row mb-0">
                        <dt class="col-4">Nama</dt>
                        <dd class="col-8" id="detail-nama">-</dd>

                        <dt class="col-4">Email</dt>
                        <dd class="col-8" id="detail-email">-</dd>

                        <dt class="col-4">Role</dt>
                        <dd class="col-8" id="detail-role">-</dd>

                        <dt class="col-4">Jurusan</dt>
                        <dd class="col-8" id="detail-jurusan">-</dd>

                        <dt class="col-4">Kelas</dt>
                        <dd class="col-8" id="detail-kelas">-</dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.search-input').forEach(input => {
    input.addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();
        const tbody = this.closest('.modal-body').querySelector('tbody');

        tbody.querySelectorAll('tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(keyword)
                ? ''
                : 'none';
        });
    });
});

// handle view button to populate detail modal
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-view');
    if (!btn) return;

    const nama = btn.dataset.nama || '-';
    const email = btn.dataset.email || '-';
    const role = btn.dataset.role || '-';
    const jurusan = btn.dataset.jurusan || '-';
    const kelas = btn.dataset.kelas || '-';

    document.getElementById('detail-nama').textContent = nama;
    document.getElementById('detail-email').textContent = email;
    document.getElementById('detail-role').textContent = role;
    document.getElementById('detail-jurusan').textContent = jurusan;
    document.getElementById('detail-kelas').textContent = kelas;
});
</script>
@endpush
