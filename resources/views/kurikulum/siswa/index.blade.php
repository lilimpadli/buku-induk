@extends('layouts.app')

@section('title', 'Manajemen Siswa')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-1">Manajemen Data Siswa</h2>
    <p class="text-muted mb-4">Kelola data siswa dengan mudah. Anda dapat menambah, mengubah, dan menghapus data.</p>

    <!-- BUTTON AKSI -->
    <div class="d-flex gap-2 mb-4">
        <a href="{{ route('kurikulum.data-siswa.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i> Input Data Siswa
        </a>
    </div>

    <!-- CARD FILTER + TABEL -->
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body">
            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>NISN</th>
                            <th>NIS</th>
                            <th>Nama Lengkap</th>
                            <th>Kelas</th>
                            <th>Angkatan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $item)
                        <tr>
                            <td>{{ $item->nisn }}</td>
                            <td>{{ $item->nis }}</td>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>{{ $item->kelas }}</td>
                            <td>{{ $item->tanggal_diterima }}</td>
                            <td class="text-center">
                                <a href="{{ route('kurikulum.data-siswa.show', $item->id) }}" class="text-dark me-2" title="Lihat">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('kurikulum.data-siswa.edit', $item->id) }}" class="text-dark me-2" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('kurikulum.data-siswa.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data siswa</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection