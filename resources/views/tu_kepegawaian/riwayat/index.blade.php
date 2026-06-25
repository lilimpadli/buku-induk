@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Riwayat Kerja</h3>
        <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahRiwayat">
            <i class="fas fa-plus me-1"></i> Tambah Riwayat
        </button>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Instansi</th>
                        <th>Jabatan</th>
                        <th>Mulai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $r)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $r->instansi }}</td>
                        <td>{{ $r->jabatan }}</td>
                        <td>{{ $r->mulai }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#editRiwayat{{ $r->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <form action="{{ route('tu_kepegawaian.riwayat.destroy', $r->id) }}" method="POST">
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="editRiwayat{{ $r->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('tu_kepegawaian.riwayat.update', $r->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content rounded-4 border-0 shadow">
                                    <div class="modal-header"><h5>Edit Riwayat Kerja</h5></div>
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
                                            <input type="date" name="mulai" class="form-control" value="{{ $r->mulai }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Update Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahRiwayat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('tu_kepegawaian.riwayat.store') }}" method="POST">
            @csrf
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header"><h5>Tambah Riwayat Kerja</h5></div>
                <div class="modal-body">
                    <input type="hidden" name="guru_id" value="1">
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
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection