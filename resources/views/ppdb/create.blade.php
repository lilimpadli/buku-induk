@extends('layouts.app')

@section('title', 'Form PPDB')

@section('noSidebar', '1')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header text-white d-flex align-items-center justify-content-between" style="background: linear-gradient(90deg,#3b82f6,#5b21b6);">
            <div>
                <h5 class="mb-0"><i class="fas fa-file-signature me-2"></i> Formulir Pendaftaran PPDB</h5>
                <small>Silahkan lengkapi data siswa di bawah ini dengan benar.</small>
            </div>
            <div>
                <a href="{{ route('ppdb.index') }}" class="btn btn-sm btn-light me-2">Batal</a>
                <button id="btn-save" type="button" class="btn btn-sm btn-white btn-outline-light">Simpan</button>
            </div>
        </div>

        <form id="ppdbForm" method="POST" action="{{ route('ppdb.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="sesi_ppdb_id" value="{{ $sesi->id ?? '' }}">
            <input type="hidden" name="jalur_ppdb_id" value="{{ $jalur->id ?? '' }}">

            <div class="card-body">
                <div class="mb-2">
                    @if($sesi)
                        <span class="badge bg-primary">Sesi: {{ $sesi->nama_sesi }} - {{ $sesi->tahun_ajaran }}</span>
                    @endif
                    @if($jalur)
                        <span class="badge bg-success ms-2">Jalur: {{ $jalur->nama_jalur }}</span>
                    @endif
                    @if(isset($jurusans) && $jurusans->count())
                        <div class="mt-2">
                            <label class="form-label">Pilih Jurusan</label>
                            <select name="jurusan_id" class="form-select w-auto">
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach($jurusans as $jr)
                                    <option value="{{ $jr->id }}" {{ old('jurusan_id') == $jr->id ? 'selected' : '' }}>{{ $jr->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-4">
                    <h6 class="text-primary"><i class="fas fa-user-graduate me-2"></i> Data Pribadi Siswa</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label">NISN</label>
                            <input type="text" name="nisn" class="form-control" value="{{ old('nisn') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Agama</label>
                            <input type="text" name="agama" class="form-control" value="{{ old('agama') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status dalam keluarga</label>
                            <input type="text" name="status_keluarga" class="form-control" value="{{ old('status_keluarga') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Anak ke</label>
                            <input type="number" name="anak_ke" class="form-control" value="{{ old('anak_ke') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">No telp rumah / HP</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat') }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Sekolah Asal</label>
                            <input type="text" name="sekolah_asal" class="form-control" value="{{ old('sekolah_asal') }}">
                        </div>

                        
                    </div>
                </div>

                <hr>

                <div class="mb-4">
                    <h6 class="text-primary"><i class="fas fa-users me-2"></i> Data Orang Tua / Wali</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" name="nama_ayah" id="nama_ayah" class="form-control" value="{{ old('nama_ayah') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan Ayah</label>
                            <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" class="form-control" value="{{ old('pekerjaan_ayah') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" value="{{ old('nama_ibu') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan Ibu</label>
                            <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" class="form-control" value="{{ old('pekerjaan_ibu') }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat Orang Tua</label>
                            <input type="text" name="alamat_orangtua" id="alamat_orangtua" class="form-control" value="{{ old('alamat_orangtua') }}">
                        </div>
                    </div>
                </div>

                <hr>

                <div class="mb-4">
                    <h6 class="text-primary"><i class="fas fa-file-upload me-2"></i> Dokumen Penting</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Berkas Kartu Keluarga (KK)</label>
                            <input type="file" name="kk" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Akte Kelahiran</label>
                            <input type="file" name="akte" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">KTP Orang Tua</label>
                            <input type="file" name="ktp_orangtua" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ijazah</label>
                            <input type="file" name="ijazah" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const sel = document.getElementById('datasiswa_select');
    if (sel) {
        sel.addEventListener('change', function(){
            const id = this.value;
            if (! id) return;
            fetch(`{{ url('/ppdb/datasiswa') }}/${id}`)
                .then(r => r.json())
                .then(data => {
                    const nAyah = document.getElementById('nama_ayah'); if (nAyah) nAyah.value = data.nama_ayah || '';
                    const pAyah = document.getElementById('pekerjaan_ayah'); if (pAyah) pAyah.value = data.pekerjaan_ayah || '';
                    const nIbu = document.getElementById('nama_ibu'); if (nIbu) nIbu.value = data.nama_ibu || '';
                    const pIbu = document.getElementById('pekerjaan_ibu'); if (pIbu) pIbu.value = data.pekerjaan_ibu || '';
                    const alamat = document.getElementById('alamat_orangtua'); if (alamat) alamat.value = data.alamat_orangtua || data.alamat || '';
                })
                .catch(err => console.error(err));
        });
    }

    // submit from header button
    const btnSave = document.getElementById('btn-save');
    const form = document.getElementById('ppdbForm');
    if (btnSave && form) {
        btnSave.addEventListener('click', function(e){
            e.preventDefault();
            form.submit();
        });
    }
});
</script>
@endpush
