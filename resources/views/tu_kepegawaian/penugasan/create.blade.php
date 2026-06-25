@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card p-4">
        <h3>Tambah Penugasan Baru</h3>
        <form action="{{ route('tu_kepegawaian.penugasan.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Pilih Guru</label>
                <select name="guru_id" class="form-select" required>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Kategori Tugas</label>
                <select name="kategori" class="form-select" id="kategori" onchange="toggleMapel()" required>
                    <option value="Wali Kelas">Wali Kelas</option>
                    <option value="Mengajar">Mengajar</option>
                    <option value="Kaprogli">Kaprogli</option>
                    <option value="Pembina Ekskul">Pembina Ekskul</option>
                </select>
            </div>

            <div class="mb-3" id="mapel-section" style="display:none;">
                <label>Mata Pelajaran</label>
                <select name="mapel_id" class="form-select">
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Detail Objek (Contoh: X RPL 1, PT ABC, dll)</label>
                <input type="text" name="detail_objek" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" class="form-control" value="2026/2027" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Penugasan</button>
        </form>
    </div>
</div>

<script>
function toggleMapel() {
    let kat = document.getElementById('kategori').value;
    document.getElementById('mapel-section').style.display = (kat === 'Mengajar') ? 'block' : 'none';
}
</script>
@endsection