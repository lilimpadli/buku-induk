@php
    $siswa = $siswa ?? null;
    $selected_kelas = old('kelas_id', $siswa?->rombel?->kelas?->id);
    $selected_rombel = old('rombel_id', $siswa?->rombel_id);
    $selected_jurusan = old('jurusan_id', $siswa?->rombel?->kelas?->jurusan?->id);
@endphp

<div class="row g-3">
    <div class="col-12">
        <h5 class="border-bottom pb-2 fw-semibold">Data Akun Siswa</h5>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="form-control" required value="{{ old('nama_lengkap', $siswa->nama_lengkap ?? '') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">NIS</label>
        <input type="text" name="nis" class="form-control" required value="{{ old('nis', $siswa->nis ?? '') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">NISN</label>
        <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $siswa->nisn ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-select" required>
            <option value="">-- Pilih --</option>
            <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Sekolah Asal</label>
        <input type="text" name="sekolah_asal" class="form-control" value="{{ old('sekolah_asal', $siswa->sekolah_asal ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Kelas</label>
        <select name="kelas_id" id="kelasSelect" class="form-select">
            <option value="">-- Pilih Kelas --</option>
            @foreach($kelas as $k)
                <option value="{{ $k->id }}" data-jurusan="{{ $k->jurusan_id }}" {{ (string)$selected_kelas === (string)$k->id ? 'selected' : '' }}>{{ $k->tingkat }} {{ $k->jurusan->nama ?? '' }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Jurusan</label>
        <select name="jurusan_id" class="form-select">
            <option value="">-- Pilih Jurusan --</option>
            @foreach($jurusans as $jur)
                <option value="{{ $jur->id }}" {{ (string)$selected_jurusan === (string)$jur->id ? 'selected' : '' }}>{{ $jur->nama ?? $jur->name ?? 'Jurusan ' . $jur->id }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Rombel</label>
        <select name="rombel_id" class="form-select" id="rombelSelect">
            <option value="">-- Pilih Rombel --</option>
            @foreach($rombels as $r)
                <option value="{{ $r->id }}" data-kelas="{{ $r->kelas_id }}" {{ (string)$selected_rombel === (string)$r->id ? 'selected' : '' }}>{{ $r->nama ?? ('Rombel ' . $r->id) }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Password{{ isset($siswa) ? ' (kosongkan bila tidak diubah)' : '' }}</label>
        <input type="password" name="password" class="form-control" {{ isset($siswa) ? '' : 'required' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" {{ isset($siswa) ? '' : 'required' }}>
    </div>

    <!-- DATA PRIBADI SISWA -->
    <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 fw-semibold">Data Pribadi Siswa</h5>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Agama</label>
        <input type="text" name="agama" class="form-control" value="{{ old('agama', $siswa->agama ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Kewarganegaraan</label>
        <input type="text" name="kewarganegaraan" class="form-control" value="{{ old('kewarganegaraan', $siswa->kewarganegaraan ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">No HP</label>
        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $siswa->no_hp ?? '') }}">
    </div>

    <!-- ALAMAT TERSTRUKTUR -->
    <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 fw-semibold">Alamat Siswa</h5>
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Dusun</label>
        <input type="text" name="dusun" class="form-control" value="{{ old('dusun', $siswa->dusun ?? '') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">RT</label>
        <input type="text" name="rt" class="form-control" placeholder="001" value="{{ old('rt', $siswa->rt ?? '') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">RW</label>
        <input type="text" name="rw" class="form-control" placeholder="001" value="{{ old('rw', $siswa->rw ?? '') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Kode Pos</label>
        <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos', $siswa->kode_pos ?? '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Kelurahan / Desa</label>
        <input type="text" name="kelurahan" class="form-control" value="{{ old('kelurahan', $siswa->kelurahan ?? '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Kecamatan</label>
        <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $siswa->kecamatan ?? '') }}">
    </div>

    <div class="col-md-12">
        <label class="form-label fw-semibold">Tanggal Diterima</label>
        <input type="date" name="tanggal_diterima" class="form-control" value="{{ old('tanggal_diterima', $siswa->tanggal_diterima ?? '') }}">
    </div>
    <!-- DATA ORANG TUA / WALI -->
    <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 fw-semibold">Data Orang Tua / Wali</h5>
    </div>

    <!-- AYAH -->
    <div class="col-md-4">
        <label class="form-label fw-semibold">Nama Ayah</label>
        <input type="text" name="nama_ayah" class="form-control"
            value="{{ old('nama_ayah', $siswa->ayah->nama ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Pekerjaan Ayah</label>
        <input type="text" name="pekerjaan_ayah" class="form-control"
            value="{{ old('pekerjaan_ayah', $siswa->ayah->pekerjaan ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Telepon Ayah</label>
        <input type="text" name="telepon_ayah" class="form-control"
            value="{{ old('telepon_ayah', $siswa->ayah->telepon ?? '') }}">
    </div>

    <!-- IBU -->
    <div class="col-md-4">
        <label class="form-label fw-semibold">Nama Ibu</label>
        <input type="text" name="nama_ibu" class="form-control"
            value="{{ old('nama_ibu', $siswa->ibu->nama ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Pekerjaan Ibu</label>
        <input type="text" name="pekerjaan_ibu" class="form-control"
            value="{{ old('pekerjaan_ibu', $siswa->ibu->pekerjaan ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Telepon Ibu</label>
        <input type="text" name="telepon_ibu" class="form-control"
            value="{{ old('telepon_ibu', $siswa->ibu->telepon ?? '') }}">
    </div>

    <!-- WALI -->
    <div class="col-md-4">
        <label class="form-label fw-semibold">Nama Wali</label>
        <input type="text" name="nama_wali" class="form-control"
            value="{{ old('nama_wali', $siswa->wali->nama ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Pekerjaan Wali</label>
        <input type="text" name="pekerjaan_wali" class="form-control"
            value="{{ old('pekerjaan_wali', $siswa->wali->pekerjaan ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Telepon Wali</label>
        <input type="text" name="telepon_wali" class="form-control"
            value="{{ old('telepon_wali', $siswa->wali->telepon ?? '') }}">
    </div>
</div>
