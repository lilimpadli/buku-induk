@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-0">Riwayat Tugas</h3>
            <p class="text-muted small">Kelola riwayat penugasan dan tugas tambahan pegawai</p>
        </div>
        <button class="btn btn-primary shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#tambahRiwayat">
            <i class="fas fa-plus me-1"></i> Tambah Tugas
        </button>
    </div>

    {{-- NOTIFIKASI DIHAPUS: sudah ditangani oleh layouts/app.blade.php --}}

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Nama Pegawai</th>
                            <th>Instansi / Tugas</th>
                            <th>Jabatan</th>
                            <th>Mulai</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $r)
                        <tr>
                            <td class="ps-4">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold">{{ $r->pegawai->nama ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $r->pegawai->nip ?? 'Tanpa NIP' }}</small>
                            </td>
                            <td>{{ $r->instansi }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $r->jabatan }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($r->mulai)->format('d M Y') }}</td>
                            <td>
                                <span class="badge {{ $r->is_tugas_tambahan ? 'bg-info bg-opacity-10 text-info' : 'bg-secondary bg-opacity-10 text-secondary' }}">
                                    {{ $r->is_tugas_tambahan ? 'Tugas Tambahan' : 'Riwayat Kerja' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editRiwayat{{ $r->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('tu_kepegawaian.riwayat.destroy', $r->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted">Data belum tersedia.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT — dipindah KELUAR dari <tbody>, di-loop terpisah --}}
@foreach($riwayat as $r)
<div class="modal fade" id="editRiwayat{{ $r->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('tu_kepegawaian.riwayat.update', $r->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Edit Riwayat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Instansi</label>
                        <input type="text" name="instansi" class="form-control" value="{{ $r->instansi }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" value="{{ $r->jabatan }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="mulai" class="form-control" value="{{ $r->mulai ? \Carbon\Carbon::parse($r->mulai)->format('Y-m-d') : '' }}" required>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_tugas_tambahan" value="1" id="editCheck{{ $r->id }}" {{ $r->is_tugas_tambahan ? 'checked' : '' }}>
                        <label class="form-check-label" for="editCheck{{ $r->id }}">Tandai sebagai Tugas Tambahan</label>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary w-100">Update Data</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="tambahRiwayat" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('tu_kepegawaian.riwayat.store') }}" method="POST">
            @csrf
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Tambah Riwayat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pegawai</label>
                        <select name="pegawai_id" class="form-select" required>
                            @foreach($pegawais as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Instansi</label>
                        <input type="text" name="instansi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="mulai" class="form-control" required>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_tugas_tambahan" value="1" id="tambahCheck">
                        <label class="form-check-label" for="tambahCheck">Tandai sebagai Tugas Tambahan</label>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary w-100">Simpan Data</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection