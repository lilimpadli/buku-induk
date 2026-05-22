@php
    $siswa = $siswa ?? null;
    $selected_kelas = old('kelas_id', $siswa?->rombel?->kelas?->id);
    $selected_rombel = old('rombel_id', $siswa?->rombel_id);
    $selected_jurusan = old('jurusan_id', $siswa?->rombel?->kelas?->jurusan?->id);
@endphp

<style>
    :root{
        --primary:#3B82F6;
        --primary-soft:#EFF6FF;
        --border:#E2E8F0;
        --text:#0F172A;
        --muted:#64748B;
    }

    .section-card{
        background:#fff;
        border:1px solid #E2E8F0;
        border-radius:24px;
        padding:28px;
        margin-bottom:24px;
        box-shadow:0 4px 20px rgba(15,23,42,.04);
    }

    .section-title{
        display:flex;
        align-items:center;
        gap:12px;
        font-size:1.1rem;
        font-weight:700;
        color:var(--text);
        margin-bottom:24px;
    }

    .section-title .icon{
        width:42px;
        height:42px;
        border-radius:14px;
        background:linear-gradient(135deg,#3B82F6,#6366F1);
        display:flex;
        align-items:center;
        justify-content:center;
        color:white;
        font-size:15px;
    }

    .form-label{
        font-size:13px;
        font-weight:700;
        color:#334155;
        margin-bottom:8px;
    }

    .form-control,
    .form-select{
        border:1.5px solid var(--border);
        border-radius:16px;
        padding:13px 16px;
        font-size:14px;
        transition:.3s ease;
        background:#fff;
        box-shadow:none;
    }

    .form-control:focus,
    .form-select:focus{
        border-color:#3B82F6;
        box-shadow:0 0 0 4px rgba(59,130,246,.10);
    }

    .input-group-text{
        border-radius:16px 0 0 16px;
        border:1.5px solid var(--border);
        background:var(--primary-soft);
        color:#2563EB;
    }

    .form-note{
        font-size:12px;
        color:var(--muted);
        margin-top:6px;
    }

    @media(max-width:768px){

        .section-card{
            padding:20px;
            border-radius:20px;
        }

        .section-title{
            font-size:1rem;
        }

    }
</style>

<!-- ================= DATA AKUN ================= -->

<div class="section-card">

    <div class="section-title">
        <div class="icon">
            <i class="fas fa-user-graduate"></i>
        </div>
        Data Akun Siswa
    </div>

    <div class="row g-4">

        <div class="col-md-6">
            <label class="form-label">Nama Lengkap</label>
            <input type="text"
                   name="nama_lengkap"
                   class="form-control"
                   required
                   placeholder="Masukkan nama lengkap"
                   value="{{ old('nama_lengkap', $siswa->nama_lengkap ?? '') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">NIS</label>
            <input type="text"
                   name="nis"
                   class="form-control"
                   required
                   placeholder="Masukkan NIS"
                   value="{{ old('nis', $siswa->nis ?? '') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">NISN</label>
            <input type="text"
                   name="nisn"
                   class="form-control"
                   placeholder="Masukkan NISN"
                   value="{{ old('nisn', $siswa->nisn ?? '') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Jenis Kelamin</label>

            <select name="jenis_kelamin"
                    class="form-select"
                    required>

                <option value="">Pilih Jenis Kelamin</option>

                <option value="Laki-laki"
                    {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>
                    Laki-laki
                </option>

                <option value="Perempuan"
                    {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>
                    Perempuan
                </option>

            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Sekolah Asal</label>
            <input type="text"
                   name="sekolah_asal"
                   class="form-control"
                   placeholder="Contoh: SMPN 1 Garut"
                   value="{{ old('sekolah_asal', $siswa->sekolah_asal ?? '') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">No HP</label>
            <input type="text"
                   name="no_hp"
                   class="form-control"
                   placeholder="08xxxxxxxxxx"
                   value="{{ old('no_hp', $siswa->no_hp ?? '') }}">
        </div>

    </div>

</div>

<!-- ================= DATA KELAS ================= -->

<div class="section-card">

    <div class="section-title">
        <div class="icon">
            <i class="fas fa-school"></i>
        </div>
        Informasi Akademik
    </div>

    <div class="row g-4">

        <div class="col-md-4">
            <label class="form-label">Jurusan</label>

            <select name="jurusan_id" class="form-select">

                <option value="">Pilih Jurusan</option>

                @foreach($jurusans as $jur)

                    <option value="{{ $jur->id }}"
                        {{ (string)$selected_jurusan === (string)$jur->id ? 'selected' : '' }}>

                        {{ $jur->nama ?? $jur->name ?? 'Jurusan ' . $jur->id }}

                    </option>

                @endforeach

            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Kelas</label>

            <select name="kelas_id"
                    id="kelasSelect"
                    class="form-select">

                <option value="">Pilih Kelas</option>

                @foreach($kelas as $k)

                    <option value="{{ $k->id }}"
                            data-jurusan="{{ $k->jurusan_id }}"
                            {{ (string)$selected_kelas === (string)$k->id ? 'selected' : '' }}>

                        {{ $k->tingkat }} {{ $k->jurusan->nama ?? '' }}

                    </option>

                @endforeach

            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Rombel</label>

            <select name="rombel_id"
                    id="rombelSelect"
                    class="form-select">

                <option value="">Pilih Rombel</option>

                @foreach($rombels as $r)

                    <option value="{{ $r->id }}"
                            data-kelas="{{ $r->kelas_id }}"
                            {{ (string)$selected_rombel === (string)$r->id ? 'selected' : '' }}>

                        {{ $r->nama ?? ('Rombel ' . $r->id) }}

                    </option>

                @endforeach

            </select>
        </div>

    </div>

</div>

<!-- ================= PASSWORD ================= -->

<div class="section-card">

    <div class="section-title">
        <div class="icon">
            <i class="fas fa-lock"></i>
        </div>
        Keamanan Akun
    </div>

    <div class="row g-4">

        <div class="col-md-6">
            <label class="form-label">
                Password
                {{ isset($siswa) ? '(Opsional)' : '' }}
            </label>

            <input type="password"
                   name="password"
                   class="form-control"
                   {{ isset($siswa) ? '' : 'required' }}>

            @if(isset($siswa))
                <div class="form-note">
                    Kosongkan jika tidak ingin mengganti password.
                </div>
            @endif
        </div>

        <div class="col-md-6">
            <label class="form-label">Konfirmasi Password</label>

            <input type="password"
                   name="password_confirmation"
                   class="form-control"
                   {{ isset($siswa) ? '' : 'required' }}>
        </div>

    </div>

</div>

