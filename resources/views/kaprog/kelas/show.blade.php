@extends('layouts.app')

@section('title', 'Detail Kelas')

@section('content')
<div class="container mt-4">
    <div class="card mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">{{ $rombel->nama }}</h5>
                <small class="text-muted">Kelas: {{ $rombel->kelas->tingkat ?? '-' }} - Jurusan: {{ $rombel->kelas->jurusan->nama ?? '-' }}</small>
            </div>
            <a href="{{ route('kaprog.kelas.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Daftar Siswa ({{ $siswa->count() }})</h6>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Rombel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $i => $s)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $s->nama_lengkap }}</td>
                                <td>{{ $s->nis }}</td>
                                <td>{{ $s->rombel->nama ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary btn-detail-siswa" data-id="{{ $s->id }}">Lihat</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada siswa di kelas ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
        function showSiswaDetail(data) {
                const modalBody = document.getElementById('siswaDetailBody');
                modalBody.innerHTML = `
                        <table class="table table-sm">
                                <tbody>
                                        <tr><th>Nama</th><td>${data.nama_lengkap || '-'}</td></tr>
                                        <tr><th>NIS</th><td>${data.nis || '-'}</td></tr>
                                        <tr><th>NISN</th><td>${data.nisn || '-'}</td></tr>
                                        <tr><th>Tempat, Tanggal Lahir</th><td>${data.tempat_lahir || '-'}, ${data.tanggal_lahir || '-'}</td></tr>
                                        <tr><th>Jenis Kelamin</th><td>${data.jenis_kelamin || '-'}</td></tr>
                                        <tr><th>Agama</th><td>${data.agama || '-'}</td></tr>
                                        <tr><th>Alamat</th><td>${data.alamat || '-'}</td></tr>
                                        <tr><th>No HP</th><td>${data.no_hp || '-'}</td></tr>
                                        <tr><th>Sekolah Asal</th><td>${data.sekolah_asal || '-'}</td></tr>
                                        <tr><th>Tanggal Diterima</th><td>${data.tanggal_diterima || '-'}</td></tr>
                                        <tr><th>Nama Ayah</th><td>${data.nama_ayah || '-'}</td></tr>
                                        <tr><th>Pekerjaan Ayah</th><td>${data.pekerjaan_ayah || '-'}</td></tr>
                                        <tr><th>Nama Ibu</th><td>${data.nama_ibu || '-'}</td></tr>
                                        <tr><th>Pekerjaan Ibu</th><td>${data.pekerjaan_ibu || '-'}</td></tr>
                                </tbody>
                        </table>
                `;
                // show modal
                const modal = new bootstrap.Modal(document.getElementById('siswaDetailModal'));
                modal.show();
        }

        document.querySelectorAll('.btn-detail-siswa').forEach(btn => {
                btn.addEventListener('click', function () {
                        const id = this.dataset.id;
                        fetch(`{{ url('kaprog/siswa') }}/${id}/detail`)
                                .then(r => r.json())
                                .then(data => showSiswaDetail(data))
                                .catch(err => {
                                        console.error(err);
                                        alert('Gagal mengambil data siswa');
                                });
                });
        });
});
</script>

<!-- Modal -->
<div class="modal fade" id="siswaDetailModal" tabindex="-1" aria-labelledby="siswaDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="siswaDetailModalLabel">Detail Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="siswaDetailBody">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endpush
