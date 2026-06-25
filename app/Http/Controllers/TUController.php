<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\User;
use App\Models\NilaiRaport;
use App\Models\Ppdb;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\MataPelajaran;
use App\Models\Ayah;
use App\Models\Guru;
use App\Models\Ibu;
use App\Models\Wali;
use App\Models\Rombel;
use App\Models\MutasiSiswa;
use App\Models\KenaikanKelas;
use App\Exports\KaprogSiswaByJurusanExport;
use App\Exports\KaprogSiswaByAngkatanExport;
use App\Exports\KaprogSiswaByRombelExport;
use App\Exports\GuruExportMultiSheet;
use App\Exports\SiswaExport;
use App\Exports\SiswaAktifExport;
use App\Exports\SiswaImportTemplate;
use App\Exports\LegerTemplate;
use App\Exports\KelasExport;
use App\Exports\KelasImportTemplate;
use App\Imports\SiswaImport;
use App\Imports\LegerImport;
use App\Imports\KelasImport;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TUController extends Controller
{
    /**
     * Dashboard TU
     */
    public function dashboard()
    {
        $totalSiswa = DataSiswa::count();
        $totalAdministrasi = DataSiswa::whereNotNull('nis')->whereNotNull('nisn')->count();
        $totalMutasi = MutasiSiswa::count();
        $totalAlumni = KenaikanKelas::where('status', 'lulus')->count();
        $siswaBaru = DataSiswa::latest()->take(5)->get();

        return view('tu.dashboard', compact(
            'totalSiswa',
            'totalAdministrasi',
            'totalMutasi',
            'totalAlumni',
            'siswaBaru'
        ));
    }

    /**
     * Daftar Siswa (sudah diurutkan A-Z)
     */
    public function siswa()
    {
        $query = DataSiswa::with(['user', 'ayah', 'ibu', 'wali'])->orderBy('nama_lengkap', 'asc');

        $tingkat = request()->query('tingkat', null);
        if ($tingkat) {
            $query->whereHas('rombel.kelas', function ($q) use ($tingkat) {
                $q->where('tingkat', $tingkat);
            });
        }

        $search = request()->query('search', null);
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $filterRombel = request()->query('rombel', null);
        if ($filterRombel) {
            $query->where('rombel_id', $filterRombel);
        }

        $allRombels = Rombel::with('kelas')->orderBy('nama')->get();
        $allJurusans = Jurusan::orderBy('nama')->get();

        $perPage = (int) request()->query('per_page', 15);
        $allowedPerPage = [15, 25, 50, 100, 200, 500];
        $perPage = in_array($perPage, $allowedPerPage) ? $perPage : 15;

        $siswas = $query->paginate($perPage)->withQueryString();
        $currentTingkat = request()->query('tingkat', '');

        return view('tu.siswa.index', compact('siswas', 'search', 'allRombels', 'filterRombel', 'allJurusans', 'currentTingkat', 'perPage'));
    }

    /**
     * Form Tambah Siswa
     */
    public function siswaCreate()
    {
        $jurusans = Jurusan::all();
        $rombels = Rombel::all();
        $kelas = Kelas::with('jurusan')->get();
        return view('tu.siswa.create', compact('jurusans', 'rombels', 'kelas'));
    }

    /**
     * Simpan Data Siswa Baru
     */
    public function siswaStore(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'nullable|string|max:30|unique:data_siswa,nis',
            'nisn' => 'nullable|string|max:30|unique:data_siswa,nisn',
            'jenis_kelamin' => 'nullable|in:L,P,Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'rombel_id' => 'nullable|exists:rombels,id',
        ]);

        DB::beginTransaction();
        try {
            $siswa = DataSiswa::create([
                'nama_lengkap' => $data['nama_lengkap'],
                'nis' => $data['nis'] ?? null,
                'nisn' => $data['nisn'] ?? null,
                'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
                'tempat_lahir' => $data['tempat_lahir'] ?? null,
                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                'alamat' => $data['alamat'] ?? null,
                'rombel_id' => $data['rombel_id'] ?? null,
            ]);

            DB::commit();
            return redirect()->route('tu.siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Detail Siswa
     */
    public function siswaDetail($id)
    {
        $siswa = DataSiswa::with(['user', 'nilaiRaports', 'ayah', 'ibu', 'wali', 'rombel.kelas'])->findOrFail($id);
        return view('tu.siswa.data-diri.show', compact('siswa'));
    }

    /**
     * Form Edit Siswa
     */
    public function siswaEdit($id)
    {
        $siswa = DataSiswa::with(['rombel.kelas', 'ayah', 'ibu', 'wali'])->findOrFail($id);
        $jurusans = Jurusan::all();
        $rombels = Rombel::all();
        $kelas = Kelas::with('jurusan')->get();
        return view('tu.siswa.edit', compact('siswa', 'jurusans', 'rombels', 'kelas'));
    }

    /**
     * Update Data Siswa
     */
    public function siswaUpdate(Request $request, $id)
    {
        $siswa = DataSiswa::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'required|string|max:20|unique:data_siswa,nis,' . $id,
            'nisn' => 'nullable|string|max:20|unique:data_siswa,nisn,' . $id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:30',
            'rombel_id' => 'nullable|exists:rombels,id',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        DB::beginTransaction();
        try {
            $siswa->update([
                'nama_lengkap' => $request->nama_lengkap,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama' => $request->agama,
                'no_hp' => $request->no_hp,
                'rombel_id' => $request->rombel_id,
            ]);

            if ($siswa->user) {
                $siswa->user->name = $request->nama_lengkap;
                $siswa->user->nomor_induk = $request->nis;
                if ($request->filled('password')) {
                    $siswa->user->password = Hash::make($request->password);
                }
                $siswa->user->save();
            }

            DB::commit();
            return redirect()->route('tu.siswa.detail', $siswa->id)->with('success', 'Data siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus Data Siswa
     */
    public function siswaDestroy($id)
    {
        $siswa = DataSiswa::findOrFail($id);

        DB::beginTransaction();
        try {
            if ($siswa->user) {
                $siswa->user->delete();
            }
            $siswa->delete();
            DB::commit();
            return redirect()->route('tu.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Export PDF Data Siswa (per individu)
     */
    public function siswaExportPdf($id)
    {
        $siswa = DataSiswa::with(['ayah', 'ibu', 'wali', 'rombel.kelas'])->findOrFail($id);

        $pdf = Pdf::loadView('tu.siswa.data-diri.pdf', compact('siswa'))
            ->setPaper('A4', 'portrait');

        $filename = 'Data_Diri_' . ($siswa->nama_lengkap ?? $siswa->nis ?? $siswa->id) . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Export Excel - Semua Data Siswa
     */
    public function exportSiswaExcel(Request $request)
    {
        $filters = $request->except('page');
        $filename = $this->buildSiswaExportFilename($filters);

        return Excel::download(new SiswaExport($filters), $filename);
    }

    public function exportSiswaByKelas(Request $request)
    {
        $rombelId = $request->query('rombel');
        $rombel = Rombel::findOrFail($rombelId);
        $filename = 'siswa_kelas_' . $this->sanitizeFilename($rombel->nama) . '.xlsx';

        return Excel::download(new KaprogSiswaByRombelExport($rombelId, $rombel->nama), $filename);
    }

    public function exportSiswaByJurusan(Request $request)
    {
        $jurusanId = $request->query('jurusan');
        $jurusan = Jurusan::findOrFail($jurusanId);
        $filename = 'siswa_jurusan_' . $this->sanitizeFilename($jurusan->nama) . '.xlsx';

        return Excel::download(new KaprogSiswaByJurusanExport($jurusanId, $jurusan->nama), $filename);
    }

    public function exportSiswaAktif()
    {
        $filename = 'siswa_aktif.xlsx';
        return Excel::download(new SiswaAktifExport(), $filename);
    }

    protected function buildSiswaExportFilename(array $filters): string
    {
        $parts = [];

        if (!empty($filters['search'])) {
            $parts[] = 'pencarian_' . $filters['search'];
        }

        if (!empty($filters['rombel'])) {
            $rombel = Rombel::find($filters['rombel']);
            $parts[] = 'kelas_' . ($rombel?->nama ?? $filters['rombel']);
        }

        if (!empty($filters['tingkat'])) {
            $parts[] = 'kelas_' . $filters['tingkat'];
        }

        if (!empty($filters['jurusan'])) {
            $parts[] = 'jurusan_' . $filters['jurusan'];
        }

        if (!empty($filters['status'])) {
            $parts[] = $filters['status'];
        }

        if (empty($parts)) {
            return 'siswa_semua.xlsx';
        }

        $filename = 'siswa_' . implode('_', $parts);
        return $this->sanitizeFilename($filename) . '.xlsx';
    }

    protected function sanitizeFilename(string $filename): string
    {
        $filename = preg_replace('/[^A-Za-z0-9 _-]/', '', $filename);
        $filename = preg_replace('/[\s]+/', '_', trim($filename));
        $filename = preg_replace('/_+/', '_', $filename);

        return strtolower($filename);
    }

    /**
     * Export Excel - Siswa per Angkatan
     */
    public function exportSiswaByAngkatan($jurusanId)
    {
        $jurusan = Jurusan::findOrFail($jurusanId);
        $filename = 'Data_Siswa_Per_Angkatan_' . $jurusan->nama . '.xlsx';
        return Excel::download(new KaprogSiswaByAngkatanExport($jurusanId, $jurusan->nama), $filename);
    }

    /**
     * Export Excel - Siswa per Rombel
     */
    public function exportSiswaByRombel($rombelId)
    {
        $rombel = Rombel::findOrFail($rombelId);
        $filename = 'Data_Siswa_Rombel_' . $rombel->nama . '.xlsx';
        return Excel::download(new KaprogSiswaByRombelExport($rombelId, $rombel->nama), $filename);
    }

    /**
     * Export Guru ke Excel
     */
    public function exportGuru()
    {
        $filename = 'Pengguna_Guru.xlsx';
        return Excel::download(new GuruExportMultiSheet(), $filename);
    }

    /**
     * Daftar Guru
     */
    public function guruIndex()
    {
        $search = request('search');
        $role_filter = request('role');
        $jurusan_id = request('jurusan');
        
        $roles = ['tu', 'guru', 'walikelas', 'kurikulum', 'kaprog'];
        
        $query = User::query()
            ->with(['guru' => function($q) {
                $q->with(['rombels.kelas.jurusan', 'jurusan']);
            }])
            ->whereIn('role', $roles);
        
        if ($role_filter && in_array($role_filter, $roles)) {
            $query->where('role', $role_filter);
        }
        
        if ($search) {
            $query->where(function($q) use($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nomor_induk', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('guru', function($gq) use($search) {
                      $gq->where('nip', 'like', "%{$search}%");
                  });
            });
        }
        
        if ($jurusan_id) {
            $query->whereHas('guru', function($gq) use($jurusan_id) {
                $gq->where('jurusan_id', $jurusan_id);
            });
        }
        
        $gurus = $query->orderBy('name')->paginate(10)->withQueryString();
        $allJurusans = Jurusan::orderBy('nama')->get();
        $roleOptions = ['tu' => 'TU', 'guru' => 'Guru', 'walikelas' => 'Wali Kelas', 'kurikulum' => 'Kurikulum', 'kaprog' => 'Kaprog'];

        return view('tu.guru.index', compact('gurus', 'search', 'jurusan_id', 'role_filter', 'allJurusans', 'roleOptions'));
    }

    /**
     * Form Tambah Guru
     */
    public function guruCreate()
    {
        $jurusans = Jurusan::orderBy('nama')->get();
        $kelas = Kelas::with('jurusan')->orderBy('tingkat')->get();
        $rombels = Rombel::with(['kelas.jurusan'])->orderBy('nama')->get();

        $kelasArr = $kelas->map(function($k){
            return [
                'value' => (string) $k->id,
                'text' => $k->tingkat . ' - ' . ($k->jurusan->nama ?? ''),
                'jurusan' => (string) ($k->jurusan_id ?? ''),
            ];
        });

        $rombelArr = $rombels->map(function($r){
            return [
                'value' => (string) $r->id,
                'text' => $r->nama,
                'kelas' => (string) ($r->kelas_id ?? ''),
            ];
        });

        $roles = [
            'walikelas' => 'Guru',
            'kaprog'    => 'Kaprog',
            'tu'        => 'TU',
            'kurikulum' => 'Kurikulum',
        ];

        return view('tu.guru.create', compact('jurusans', 'kelas', 'rombels', 'roles', 'kelasArr', 'rombelArr'));
    }

    /**
     * Simpan Guru
     */
    public function guruStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nik' => 'required|string|max:50|unique:users,nomor_induk',
            'nip' => 'required|string|max:30|unique:gurus,nip',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'email' => 'nullable|email|unique:users,email',
            'telepon' => 'nullable|string|max:30',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->nama,
                'nomor_induk' => $request->nik,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'guru',
            ]);

            $guru = Guru::create([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'email' => $request->email,
                'telepon' => $request->telepon ?? null,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'jurusan_id' => $request->jurusan_id,
                'user_id' => $user->id,
            ]);

            DB::commit();
            return redirect()->route('tu.guru.index')->with('success', 'Guru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Detail Guru
     */
    public function guruShow($id)
    {
        $guru = Guru::with(['user', 'rombels.kelas.jurusan'])->findOrFail($id);
        return view('tu.guru.show', compact('guru'));
    }

    /**
     * Form Edit Guru
     */
    public function guruEdit($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        $jurusans = Jurusan::orderBy('nama')->get();
        $kelas = Kelas::with('jurusan')->orderBy('tingkat')->get();
        $rombels = Rombel::with(['kelas.jurusan'])->orderBy('nama')->get();

        $kelasArr = $kelas->map(function ($k) {
            return [
                'value'   => (string) $k->id,
                'text'    => $k->tingkat . ' - ' . ($k->jurusan->nama ?? ''),
                'jurusan' => (string) ($k->jurusan_id ?? ''),
            ];
        });

        $rombelArr = $rombels->map(function ($r) {
            return [
                'value' => (string) $r->id,
                'text'  => $r->nama,
                'kelas' => (string) ($r->kelas_id ?? ''),
            ];
        });

        $roles = [
            'walikelas' => 'Guru',
            'kaprog'    => 'Kaprog',
            'tu'        => 'TU',
            'kurikulum' => 'Kurikulum',
        ];

        return view('tu.guru.edit', compact('guru', 'jurusans', 'kelas', 'rombels', 'roles', 'kelasArr', 'rombelArr'));
    }

    /**
     * Update Guru
     */
    public function guruUpdate(Request $request, $id)
    {
        $guru = Guru::with('user')->findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_induk' => 'required|string|max:50|unique:users,nomor_induk,' . $guru->user_id,
            'email' => 'nullable|email',
            'password' => 'nullable|string|min:6',
            'role' => 'required|string',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'rombel_id' => 'nullable|exists:rombels,id',
        ]);

        $user = $guru->user;
        $user->name = $data['nama'];
        $user->nomor_induk = $data['nomor_induk'];
        $user->email = $data['email'] ?? null;
        $user->role = $data['role'];

        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();

        $guru->update([
            'nama' => $data['nama'],
            'nip' => $data['nomor_induk'],
            'email' => $data['email'] ?? ($data['nomor_induk'] . '@no-reply.local'),
            'jurusan_id' => $data['jurusan_id'] ?? null,
            'kelas_id' => $data['kelas_id'] ?? null,
        ]);

        Rombel::where('guru_id', $guru->id)->update(['guru_id' => null]);

        if (!empty($data['rombel_id'])) {
            $rombel = Rombel::find($data['rombel_id']);
            $rombel->guru_id = $guru->id;
            $rombel->save();
            $guru->rombel_id = $rombel->id;
        } else {
            $guru->rombel_id = null;
        }
        $guru->save();

        return redirect()->route('tu.guru.index')->with('success', 'Guru berhasil diperbarui');
    }

    /**
     * Hapus Guru
     */
    public function guruDestroy($id)
    {
        $guru = Guru::findOrFail($id);
        if ($guru->user) {
            $guru->user->delete();
        }
        $guru->delete();

        return redirect()->route('tu.guru.index')->with('success', 'Guru berhasil dihapus');
    }

    /**
     * Halaman raport siswa (TU)
     */
    public function siswaRaport($id)
    {
        $siswa = DataSiswa::findOrFail($id);
        $raports = NilaiRaport::select('semester', 'tahun_ajaran')
            ->where('siswa_id', $id)
            ->groupBy('semester', 'tahun_ajaran')
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'asc')
            ->get();

        return view('tu.siswa.raport.list', compact('siswa', 'raports'));
    }

    /**
     * Cetak raport (TU)
     */
    public function cetakRaport($siswa_id, $semester, $tahun)
    {
        $tahun = str_replace('-', '/', $tahun);
        $siswa = DataSiswa::findOrFail($siswa_id);

        $nilaiRaports = NilaiRaport::with('mapel', 'rombel')
            ->where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();

        $rombelRaport = $nilaiRaports->first()?->rombel;

        $ekstra = \App\Models\EkstrakurikulerSiswa::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();
        $kehadiran = \App\Models\Kehadiran::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();
        $info = \App\Models\RaporInfo::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();
        $kenaikan = \App\Models\KenaikanKelas::with('rombelTujuan')
            ->where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $pdf = Pdf::loadView('tu.siswa.raport.pdf', compact('siswa', 'nilaiRaports', 'ekstra', 'kehadiran', 'info', 'semester', 'tahun', 'kenaikan', 'rombelRaport'))
            ->setPaper('A4', 'portrait');

        $safeName = str_replace(['\\', '/'], '-', $siswa->nama_lengkap);
        $safeTahun = str_replace(['\\', '/'], '-', $tahun);
        $filename = 'Raport - ' . $safeName . ' - ' . $semester . ' - ' . $safeTahun . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Show a specific raport (TU view)
     */
    public function nilaiRaportShow(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $semester = $request->semester;
        $tahunParam = $request->tahun;
        $tahun = is_string($tahunParam) ? trim(str_replace('-', '/', $tahunParam)) : $tahunParam;

        if (!$siswa_id || !$semester || !$tahun) {
            abort(404, "Parameter tidak lengkap.");
        }

        $siswa = DataSiswa::findOrFail($siswa_id);
        $nilaiRaports = NilaiRaport::with(['mapel','kelas','rombel'])
            ->where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->orderBy('mata_pelajaran_id')
            ->get();

        if ($nilaiRaports->isEmpty()) {
            return redirect()->back()->with('error', 'Data raport tidak ditemukan');
        }

        $firstNilai = $nilaiRaports->first();
        $kelasRaport = $firstNilai->kelas ?? ($siswa->rombel->kelas ?? null);
        $rombelRaport = $firstNilai->rombel ?? ($siswa->rombel ?? null);

        $ekstra = \App\Models\EkstrakurikulerSiswa::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();
        $kehadiran = \App\Models\Kehadiran::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();
        $info = \App\Models\RaporInfo::where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();
        $kenaikan = \App\Models\KenaikanKelas::with('rombelTujuan')
            ->where('siswa_id', $siswa_id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        return view('tu.siswa.raport.show', compact('siswa', 'semester', 'tahunParam', 'tahun', 'nilaiRaports', 'ekstra', 'kehadiran', 'info', 'kenaikan', 'kelasRaport', 'rombelRaport'));
    }

    /**
     * Edit raport (TU view)
     */
    public function nilaiRaportEdit(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $semester = $request->semester;
        $tahunParam = $request->tahun;
        $tahun = is_string($tahunParam) ? trim(str_replace('-', '/', $tahunParam)) : $tahunParam;

        if (!$siswa_id || !$semester || !$tahun) {
            abort(404, "Parameter tidak lengkap.");
        }

        $siswa = DataSiswa::findOrFail($siswa_id);
        $nilaiRaports = NilaiRaport::with(['kelas', 'mapel'])
            ->where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();

        $nilai = $nilaiRaports->keyBy('mata_pelajaran_id');
        $kelompokA = MataPelajaran::where('kelompok', 'A')->orderBy('urutan');
        $kelompokB = MataPelajaran::where('kelompok', 'B')->orderBy('urutan');

        if ($siswa->rombel && $siswa->rombel->kelas) {
            $kelasRaport = $nilaiRaports->first()?->kelas ?? $siswa->rombel->kelas;
            $rombelRaport = $nilaiRaports->first()?->rombel ?? ($siswa->rombel ?? null);
            $tingkat = $kelasRaport ? (string) $kelasRaport->tingkat : null;
            $currentJurusanId = $kelasRaport->jurusan_id ?? null;

            $toInt = function($t) {
                $map = ['I'=>1,'II'=>2,'III'=>3,'IV'=>4,'V'=>5,'VI'=>6,'VII'=>7,'VIII'=>8,'IX'=>9,'X'=>10,'XI'=>11,'XII'=>12];
                $tUp = strtoupper(trim($t));
                if (is_numeric($tUp)) return (int)$tUp;
                return $map[$tUp] ?? null;
            };
            $fromInt = function($n) {
                $map = [1=>'I',2=>'II',3=>'III',4=>'IV',5=>'V',6=>'VI',7=>'VII',8=>'VIII',9=>'IX',10=>'X',11=>'XI',12=>'XII'];
                return $map[$n] ?? (string)$n;
            };

            $opts = [$tingkat];
            $cur = $toInt($tingkat);
            if ($cur !== null) {
                $opts[] = (string) $cur;
                $opts[] = $fromInt($cur);
            }
            $opts = array_values(array_unique(array_filter($opts)));

            if (class_exists(\App\Models\MataPelajaranTingkat::class)) {
                try {
                    $kelompokA = $kelompokA->whereHas('tingkats', function($q) use ($opts) {
                        $q->whereIn('tingkat', $opts);
                    });
                    $kelompokB = $kelompokB->whereHas('tingkats', function($q) use ($opts) {
                        $q->whereIn('tingkat', $opts);
                    });

                    if (!empty($currentJurusanId)) {
                        $kelompokA = $kelompokA->where(function($q) use ($currentJurusanId) {
                            $q->whereDoesntHave('jurusans')
                              ->orWhereHas('jurusans', function($jq) use ($currentJurusanId) {
                                  $jq->where('jurusan_id', $currentJurusanId);
                              });
                        });
                        $kelompokB = $kelompokB->where(function($q) use ($currentJurusanId) {
                            $q->whereDoesntHave('jurusans')
                              ->orWhereHas('jurusans', function($jq) use ($currentJurusanId) {
                                  $jq->where('jurusan_id', $currentJurusanId);
                              });
                        });
                    }
                } catch (\Exception $e) {}
            }
        }

        $kelompokA = $kelompokA->get();
        $kelompokB = $kelompokB->get();

        $ekstra = \App\Models\EkstrakurikulerSiswa::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();
        $kehadiran = \App\Models\Kehadiran::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();
        $info = \App\Models\RaporInfo::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();
        $kenaikan = \App\Models\KenaikanKelas::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();
        $rombels = Rombel::orderBy('nama')->get();

        return view('tu.siswa.raport.edit', compact('siswa','semester','tahunParam','tahun','nilai','kelompokA','kelompokB','ekstra','kehadiran','info','kenaikan','rombels','kelasRaport','rombelRaport'));
    }

    /**
     * Update raport
     */
    public function nilaiRaportUpdate(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $semester = $request->semester;
        $tahunParam = $request->tahun;
        $tahun = is_string($tahunParam) ? str_replace('-', '/', $tahunParam) : $tahunParam;

        if (!$siswa_id || !$semester || !$tahun) {
            abort(404, "Parameter tidak lengkap.");
        }

        $siswa = DataSiswa::findOrFail($siswa_id);

        if ($request->nilai) {
            foreach ($request->nilai as $mapel_id => $value) {
                $trimmedTahun = is_string($tahun) ? trim($tahun) : $tahun;
                $where = [
                    'siswa_id' => $siswa->id,
                    'mata_pelajaran_id' => $mapel_id,
                    'semester' => $semester,
                    'tahun_ajaran' => $trimmedTahun,
                ];

                $existing = NilaiRaport::where($where)->first();
                $hasNilai = isset($value['nilai_akhir']) && $value['nilai_akhir'] !== '';
                $hasDeskripsi = isset($value['deskripsi']) && $value['deskripsi'] !== '';

                if (!$existing && !$hasNilai && !$hasDeskripsi) {
                    continue;
                }

                if ($existing) {
                    $existing->nilai_akhir = $hasNilai ? $value['nilai_akhir'] : ($existing->nilai_akhir ?? null);
                    $existing->deskripsi = $hasDeskripsi ? $value['deskripsi'] : ($existing->deskripsi ?? null);
                    if (empty($existing->rombel_id)) {
                        $existing->rombel_id = $siswa->rombel_id ?? null;
                    }
                    if (empty($existing->kelas_id)) {
                        $existing->kelas_id = $siswa->rombel && $siswa->rombel->kelas ? $siswa->rombel->kelas->id : null;
                    }
                    $existing->save();
                } else {
                    NilaiRaport::create([
                        'siswa_id' => $siswa->id,
                        'mata_pelajaran_id' => $mapel_id,
                        'semester' => $semester,
                        'tahun_ajaran' => $trimmedTahun,
                        'nilai_akhir' => $hasNilai ? $value['nilai_akhir'] : null,
                        'deskripsi' => $hasDeskripsi ? $value['deskripsi'] : null,
                        'rombel_id' => $siswa->rombel_id ?? null,
                        'kelas_id' => $siswa->rombel && $siswa->rombel->kelas ? $siswa->rombel->kelas->id : null,
                    ]);
                }
            }
        }

        if ($request->ekstra) {
            foreach ($request->ekstra as $data) {
                if (empty($data['nama_ekstra'])) continue;
                \App\Models\EkstrakurikulerSiswa::updateOrCreate(
                    ['siswa_id' => $siswa->id, 'nama_ekstra' => $data['nama_ekstra'], 'semester' => $semester, 'tahun_ajaran' => $tahun],
                    ['predikat' => $data['predikat'] ?? null, 'keterangan' => $data['keterangan'] ?? null]
                );
            }
        }

        $whereKehadiran = ['siswa_id' => $siswa->id, 'semester' => $semester, 'tahun_ajaran' => $tahun];
        $existingKehadiran = \App\Models\Kehadiran::where($whereKehadiran)->first();
        $hadir = $request->hadir ?? [];

        $sakit = isset($hadir['sakit']) && $hadir['sakit'] !== '' ? $hadir['sakit'] : ($existingKehadiran->sakit ?? 0);
        $izin  = isset($hadir['izin']) && $hadir['izin'] !== '' ? $hadir['izin'] : ($existingKehadiran->izin ?? 0);
        $alpa  = isset($hadir['alpa']) && $hadir['alpa'] !== '' ? $hadir['alpa'] : ($existingKehadiran->tanpa_keterangan ?? 0);

        \App\Models\Kehadiran::updateOrCreate($whereKehadiran, [
            'sakit' => $sakit, 'izin' => $izin, 'tanpa_keterangan' => $alpa,
        ]);

        $whereInfo = ['siswa_id' => $siswa->id, 'semester' => $semester, 'tahun_ajaran' => $tahun];
        $existingInfo = \App\Models\RaporInfo::where($whereInfo)->first();
        $infoIn = $request->info ?? [];

        $wali_kelas = isset($infoIn['wali_kelas']) && $infoIn['wali_kelas'] !== '' ? $infoIn['wali_kelas'] : ($existingInfo->wali_kelas ?? '');
        $nip_wali = isset($infoIn['nip_wali']) && $infoIn['nip_wali'] !== '' ? $infoIn['nip_wali'] : ($existingInfo->nip_wali ?? '');
        $kepala = isset($infoIn['kepsek']) && $infoIn['kepsek'] !== '' ? $infoIn['kepsek'] : ($existingInfo->kepala_sekolah ?? '');
        $nip_kepsek = isset($infoIn['nip_kepsek']) && $infoIn['nip_kepsek'] !== '' ? $infoIn['nip_kepsek'] : ($existingInfo->nip_kepsek ?? '');
        $tanggal = isset($infoIn['tanggal_rapor']) && $infoIn['tanggal_rapor'] !== '' ? $infoIn['tanggal_rapor'] : ($existingInfo->tanggal_rapor ?? date('Y-m-d'));

        \App\Models\RaporInfo::updateOrCreate($whereInfo, [
            'wali_kelas' => $wali_kelas, 'nip_wali' => $nip_wali, 'kepala_sekolah' => $kepala, 'nip_kepsek' => $nip_kepsek, 'tanggal_rapor' => $tanggal,
        ]);

        $whereKenaikan = ['siswa_id' => $siswa->id, 'semester' => $semester, 'tahun_ajaran' => $tahun];
        $existingKenaikan = \App\Models\KenaikanKelas::where($whereKenaikan)->first();
        $kenaikanIn = $request->kenaikan ?? [];

        $status = isset($kenaikanIn['status']) && $kenaikanIn['status'] !== '' ? $kenaikanIn['status'] : ($existingKenaikan->status ?? '-');
        $rombel_tujuan = isset($kenaikanIn['rombel_tujuan_id']) && $kenaikanIn['rombel_tujuan_id'] !== '' ? $kenaikanIn['rombel_tujuan_id'] : ($existingKenaikan->rombel_tujuan_id ?? null);
        $catatan = isset($kenaikanIn['catatan']) && $kenaikanIn['catatan'] !== '' ? $kenaikanIn['catatan'] : ($existingKenaikan->catatan ?? '');

        \App\Models\KenaikanKelas::updateOrCreate($whereKenaikan, [
            'status' => $status, 'rombel_tujuan_id' => $rombel_tujuan, 'catatan' => $catatan,
        ]);

        return redirect()->route('tu.nilai_raport.show', [
            'siswa_id' => $siswa->id, 'semester' => $semester, 'tahun' => $tahunParam
        ])->with('success', 'Rapor berhasil diperbarui!');
    }

    /**
     * Download template import data diri siswa
     */
    public function downloadTemplate()
    {
        $filename = 'template-siswa.xlsx';
        return Excel::download(new \App\Exports\SiswaImportTemplate(), $filename);
    }

    /**
     * Legacy alias for backward compatibility.
     */
    public function downloadSiswaTemplate()
    {
        return $this->downloadTemplate();
    }

    /**
     * Import data diri siswa dari file Excel
     */
    public function importSiswa(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ], [
            'file.required' => 'File tidak boleh kosong',
            'file.mimes' => 'Format file harus .xlsx, .xls, atau .csv',
            'file.max' => 'Ukuran file maksimal 5MB',
        ]);

        try {
            $import = new \App\Imports\SiswaImport();
            Excel::import($import, $request->file('file'));

            $successCount = $import->getSuccessCount();
            $errors = $import->getErrors();

            if ($successCount > 0) {
                $message = "Import berhasil: {$successCount} data siswa berhasil diimport";
                if (count($errors) > 0) {
                    $warningMessage = " Import selesai dengan " . count($errors) . " peringatan.";
                    return redirect()->route('tu.siswa.index')
                        ->with('success', $message . $warningMessage)
                        ->with('import_warnings', $errors);
                }

                return redirect()->route('tu.siswa.index')
                    ->with('success', 'Import berhasil');
            }

            $message = 'Import tidak berhasil. Pastikan file template dan data sudah benar.';
            return redirect()->route('tu.siswa.index')
                ->with('error', $message);
        } catch (\Exception $e) {
            Log::error('Siswa import error', ['error' => $e->getMessage()]);
            return redirect()->route('tu.siswa.index')
                ->with('error', 'Terjadi kesalahan saat mengimport file: ' . $e->getMessage());
        }
    }

    /**
     * Halaman daftar kelas
     */
    public function kelas()
    {
        $search = request('search');
        $jurusan_id = request('jurusan');
        
        $rombels = Rombel::with(['kelas.jurusan', 'guru'])
            ->when($search, function($query) use($search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhereHas('kelas', function($q) use($search) {
                          $q->where('tingkat', 'like', "%{$search}%")
                            ->orWhereHas('jurusan', function($j) use($search) {
                                $j->where('nama', 'like', "%{$search}%");
                            });
                      });
            })
            ->when($jurusan_id, function($query) use($jurusan_id) {
                $query->whereHas('kelas', function($q) use($jurusan_id) {
                    $q->where('jurusan_id', $jurusan_id);
                });
            })
            ->orderBy('nama')
            ->paginate(12)
            ->withQueryString();

        $allJurusans = Jurusan::orderBy('nama')->get();
        $allRombels = Rombel::with(['kelas.jurusan', 'guru'])->orderBy('nama')->get();

        return view('tu.kelas.index', compact('rombels', 'allJurusans', 'search', 'jurusan_id', 'allRombels'));
    }

    /**
     * Export all kelas data to Excel
     */
    public function exportKelasAll()
    {
        $filename = 'kelas_all.xlsx';
        return Excel::download(new KelasExport(), $filename);
    }

    /**
     * Download kelas import template
     */
    public function downloadKelasTemplate()
    {
        $filename = 'template-kelas.xlsx';
        return Excel::download(new KelasImportTemplate(), $filename);
    }

    /**
     * Import kelas data from Excel
     */
    public function importKelas(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ], [
            'file.required' => 'File tidak boleh kosong',
            'file.mimes' => 'Format file harus .xlsx, .xls, atau .csv',
            'file.max' => 'Ukuran file maksimal 5MB',
        ]);

        try {
            $import = new KelasImport();
            Excel::import($import, $request->file('file'));

            $successCount = $import->getSuccessCount();
            $errors = $import->getErrors();

            $message = 'Import berhasil';
            if ($successCount > 0) {
                $message = "Import berhasil: {$successCount} data kelas berhasil diproses";
            }

            if (count($errors) > 0) {
                return redirect()->route('tu.kelas.index')
                    ->with('success', $message)
                    ->with('import_warnings', $errors);
            }

            return redirect()->route('tu.kelas.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Kelas import error', ['error' => $e->getMessage()]);
            return redirect()->route('tu.kelas.index')
                ->with('error', 'Terjadi kesalahan saat mengimport file: ' . $e->getMessage());
        }
    }

    /**
     * Halaman tambah kelas
     */
    public function kelasCreate()
    {
        $jurusans = Jurusan::all();
        $tingkats = ['X','XI','XII'];
        $gurus = Guru::all();
        return view('tu.kelas.create', compact('jurusans','tingkats','gurus'));
    }

    /**
     * Simpan data kelas baru
     */
    public function kelasStore(Request $request)
    {
        $request->validate([
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusans,id'
        ]);
        Kelas::create($request->only(['tingkat','jurusan_id','nama']));
        return redirect()->route('tu.kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    /**
     * Halaman detail kelas
     */
    public function kelasDetail(Request $request, $id)
    {
        $rombel = Rombel::with(['kelas.jurusan', 'guru', 'siswa' => function($query) {
            $query->with(['ayah', 'ibu', 'wali']);
        }])->find($id);

        if ($rombel) {
            return view('tu.kelas.show', compact('rombel'));
        }

        $kelas = Kelas::with(['jurusan', 'rombels.guru'])->findOrFail($id);
        $rombels = $kelas->rombels ?? collect();
        return view('tu.kelas.detail_kelas', compact('kelas', 'rombels'));
    }

    /**
     * Halaman edit kelas
     */
    public function kelasEdit($id)
    {
        $rombel = Rombel::findOrFail($id);
        $jurusans = Jurusan::all();
        $gurus = Guru::all();
        $tingkats = ['X','XI','XII'];
        return view('tu.kelas.edit', compact('rombel', 'jurusans', 'gurus', 'tingkats'));
    }

    /**
     * Update data rombel
     */
    public function kelasUpdate(Request $request, $id)
    {
        $rombel = Rombel::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'guru_id' => 'required|exists:gurus,id',
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusans,id'
        ]);
        
        // Update Rombel
        $rombel->update($request->only(['nama', 'guru_id']));
        
        // Update Kelas (tingkat & jurusan)
        $rombel->kelas->update($request->only(['tingkat', 'jurusan_id']));
        
        return redirect()->route('tu.kelas.show', $id)->with('success', 'Data rombel berhasil diperbarui.');
    }

    /**
     * Hapus data kelas
     */
    public function kelasDestroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return redirect()->route('tu.kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }

    /**
     * Download template leger
     */
    public function downloadLegerTemplate(Request $request)
    {
        $request->validate([
            'rombel_id' => 'required|exists:rombels,id',
            'semester' => 'required|in:1,2',
            'tahun_ajaran' => 'required|string',
        ]);

        $rombelId = $request->rombel_id;
        $rombel = Rombel::findOrFail($rombelId);
        $rombelName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $rombel->nama);
        $tahunAjaranClean = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $request->tahun_ajaran);

        $export = new LegerTemplate($rombelId, $request->semester, $request->tahun_ajaran);
        $filename = "Leger_{$rombelName}_Sem{$request->semester}_{$tahunAjaranClean}.xlsx";

        return Excel::download($export, $filename);
    }

    /**
     * Import leger
     */
    public function importLedger(Request $request)
    {
        $request->validate([
            'rombel_id' => 'required|exists:rombels,id',
            'semester' => 'required|in:1,2',
            'tahun_ajaran' => 'required|string',
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $rombel = Rombel::findOrFail($request->rombel_id);

        try {
            $import = new LegerImport($request->rombel_id, $request->semester, $request->tahun_ajaran);
            Excel::import($import, $request->file('file'));

            $errors = $import->getErrors();
            $successCount = $import->getSuccessCount();

            if (count($errors) > 0) {
                $errorDisplay = array_slice($errors, 0, 5);
                $errorMsg = "Import selesai dengan " . count($errors) . " warning. Berhasil: {$successCount}. Error: " . implode(' | ', $errorDisplay);
                return redirect()->route('tu.kelas.index')->with('warning', $errorMsg);
            }

            return redirect()->route('tu.kelas.index')->with('success', "Import berhasil! {$successCount} siswa diproses.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Halaman daftar wali kelas
     */
    public function waliKelas()
    {
        $waliKelas = Guru::with(['user', 'kelas', 'jurusan', 'rombels'])->latest()->paginate(10);
        $jurusans = Jurusan::with(['gurus.user', 'gurus.kelas'])->get();
        return view('tu.wali-kelas.index', compact('waliKelas', 'jurusans'));
    }

    /**
     * Halaman detail wali kelas
     */
    public function waliKelasDetail($id)
    {
        $waliKelas = Guru::with(['user', 'kelas', 'jurusan', 'rombels'])->findOrFail($id);
        return view('tu.wali-kelas.show', compact('waliKelas'));
    }

    /**
     * Halaman laporan nilai raport
     */
    public function laporanNilai()
    {
        $nilaiRaports = NilaiRaport::with(['siswa' => function($query) {
            $query->with(['ayah', 'ibu', 'wali']);
        }])->orderBy('tahun_ajaran', 'desc')->orderBy('semester', 'desc')->paginate(20);
            
        return view('tu.laporan-nilai', compact('nilaiRaports'));
    }
}