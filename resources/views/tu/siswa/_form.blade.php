@php
    $siswa = $siswa ?? null;
    $selected_kelas = old('kelas_id', optional(optional($siswa)->rombel->kelas)->id);
    $selected_rombel = old('rombel_id', $siswa->rombel_id ?? null);
    $selected_jurusan = old('jurusan_id', optional(optional(optional($siswa)->rombel->kelas)->jurusan)->id);
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
</div>
