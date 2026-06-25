@extends('layouts.app')

@section('title', 'Data Mutasi Pegawai')

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 fw-bold mb-0">
                    <i class="fas fa-exchange-alt text-primary me-2"></i> Data Mutasi Pegawai
                </h1>
                <a href="{{ route('tu_kepegawaian.mutasi.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Mutasi
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Pegawai</th>
                            <th>Jenis Mutasi</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mutasis as $m)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $m->pegawai->nama ?? 'Tidak ada data' }}</td>
                            <td>
                                <span class="badge {{ $m->jenis == 'Masuk' ? 'bg-success' : ($m->jenis == 'Keluar' ? 'bg-danger' : 'bg-primary') }}">
                                    {{ $m->jenis }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($m->tanggal)->format('d M Y') }}</td>
                            <td>{{ $m->keterangan }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Tombol Pemicu Modal --}}
                                    <button type="button" class="btn btn-sm btn-outline-info" 
                                            onclick="setMutasiId('{{ $m->id }}')" 
                                            data-bs-toggle="modal" data-bs-target="#uploadModal" title="Upload Dokumen">
                                        <i class="fas fa-file-upload"></i>
                                    </button>
                                    
                                    <a href="{{ route('tu_kepegawaian.mutasi.edit', $m->id) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                                    
                                    <form action="{{ route('tu_kepegawaian.mutasi.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Yakin?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data mutasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL UPLOAD --}}
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('tu_kepegawaian.dokumen.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="mutasi_id" id="modal_mutasi_id">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header"><h5 class="modal-title">Upload Dokumen Mutasi</h5></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Dokumen</label>
                        <input type="text" name="nama_dokumen" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih File (PDF/JPG/PNG)</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function setMutasiId(id) {
    document.getElementById('modal_mutasi_id').value = id;
}
</script>
@endsection