<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\User;
use App\Models\NilaiRaport;
use App\Models\Ppdb;
use App\Models\Kelas;
use App\Models\Semester; 
use App\Models\TahunAjaran; 
use App\Models\Jurusan;
use App\Models\MataPelajaran;
use App\Models\Ayah;
use App\Models\Agama;
use App\Models\Guru;
use App\Models\Ibu;
use App\Models\JenisKelamin;
use App\Models\Wali;
use App\Models\Rombel;
use App\Models\MutasiSiswa;
use App\Models\KenaikanKelas;
use App\Models\NomorSurat;
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
use App\Http\Controllers\Rombels; 
use App\Imports\SiswaImport;
use App\Imports\LegerImport;
use App\Imports\KelasImport;
use App\Exports\DaftarHadirExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TUController extends Controller
{
    public function dashboard()
    {
        $totalSiswa = DataSiswa::count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalWaliKelas = User::where('role', 'walikelas')->count();
        $totalKelas = Kelas::count();
        $totalAdministrasi = DataSiswa::whereNotNull('nis')->whereNotNull('nisn')->count();
        $totalMutasi = MutasiSiswa::count();
        $totalAlumni = KenaikanKelas::where('status', 'lulus')->count();
        
        $jurusan = null;
        
        $aktivitas = [
            ['nama' => 'Ahmad Rizki', 'kelas' => 'XII RPL 1', 'aktivitas' => 'Penambahan data nilai', 'waktu' => '2 jam yang lalu'],
            ['nama' => 'Siti Nurhaliza', 'kelas' => 'XI TKJ 2', 'aktivitas' => 'Update profil siswa', 'waktu' => '5 jam yang lalu'],
            ['nama' => 'Budi Santoso', 'kelas' => 'X MM 1', 'aktivitas' => 'Pengajuan pindah kelas', 'waktu' => '1 hari yang lalu']
        ];
        
        $siswaBaru = DataSiswa::with(['user'])->latest()->take(5)->get();
        $waliKelas = User::where('role', 'walikelas')->get();
        $waliKelasLimit = User::where('role', 'walikelas')->take(5)->get();
        $kelasLimit = Kelas::with('jurusan')->take(5)->get();
        $totalNilai = NilaiRaport::count();
        $nilaiTerbaru = NilaiRaport::with('siswa')->latest()->take(5)->get();
        
        return view('tu.dashboard', compact(
            'totalSiswa', 'totalGuru', 'totalWaliKelas', 'totalKelas',
            'jurusan', 'aktivitas', 'siswaBaru', 'waliKelas', 'waliKelasLimit',
            'kelasLimit', 'totalNilai', 'nilaiTerbaru', 'totalAdministrasi',
            'totalMutasi', 'totalAlumni'
        ));
    }

       public function siswa(Request $request)
    {
        $query = DataSiswa::with(['user', 'rombel.kelas.jurusan', 'mutasiTerakhir'])
            ->orderBy('nama_lengkap', 'asc');

        $statusFilter = request()->query('status', 'aktif');

        // 🔥 DAFTAR STATUS TERMINAL — siswa yang keluar dari sistem
        $terminalStatuses = ['lulus', 'pindah', 'do', 'meninggal'];

        if ($statusFilter === 'aktif') {
            // Siswa aktif = TIDAK punya mutasi terminal (pindah/do/lulus/meninggal)
            $query->whereDoesntHave('mutasiTerakhir', function ($q) use ($terminalStatuses) {
                $q->whereIn('status', $terminalStatuses);
            });
        } elseif ($statusFilter === 'alumni') {
            // Alumni = status lulus
            $query->whereHas('mutasiTerakhir', function ($q) {
                $q->where('status', 'lulus');
            });
        } elseif ($statusFilter === 'pindah') {
            // Khusus pindah
            $query->whereHas('mutasiTerakhir', function ($q) {
                $q->where('status', 'pindah');
            });
        } elseif ($statusFilter === 'do') {
            // Khusus DO
            $query->whereHas('mutasiTerakhir', function ($q) {
                $q->where('status', 'do');
            });
        } elseif ($statusFilter === 'meninggal') {
            // Khusus meninggal
            $query->whereHas('mutasiTerakhir', function ($q) {
                $q->where('status', 'meninggal');
            });
        }
        // 'semua' = gak ada filter

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

        $allRombels = Rombel::with(['kelas', 'konsentrasiKeahlian'])->orderBy('nama')->get();
        $allJurusans = Jurusan::orderBy('nama')->get();

        $perPage = (int) request()->query('per_page', 15);
        $allowedPerPage = [15, 25, 50, 100, 200, 500];
        $perPage = in_array($perPage, $allowedPerPage) ? $perPage : 15;

        $siswas = $query->paginate($perPage)->withQueryString();
        $currentTingkat = request()->query('tingkat', '');

        $tahunAjarans = TahunAjaran::pluck('tahun')->toArray();
        if (empty($tahunAjarans)) {
            $currentYear = date('Y');
            $tahunAjarans = [
                $currentYear . '/' . ($currentYear + 1),
                ($currentYear - 1) . '/' . $currentYear,
                ($currentYear - 2) . '/' . ($currentYear - 1),
            ];
        }

        return view('tu.siswa.index', compact(
            'siswas', 'search', 'allRombels', 'filterRombel',
            'allJurusans', 'currentTingkat', 'perPage', 'tahunAjarans', 'statusFilter'
        ));
    }

    public function siswaCreate()
    {
        $jurusans = Jurusan::all();
        $rombels = Rombel::all();
        $kelas = Kelas::with('jurusan')->get();
        $jenisKelamins = JenisKelamin::all();
        $agamas = Agama::all();
        return view('tu.siswa.create', compact('jurusans', 'rombels', 'kelas', 'jenisKelamins', 'agamas'));
    }

public function siswaStore(Request $request)
{
    $isAgamaLainnya = $request->input('agama_id') === 'other';

    if ($isAgamaLainnya) {
        $request->merge(['agama_id' => null]);
    }

    $data = $request->validate([
        'nama_lengkap'     => 'required|string|max:255',
        'nis'              => 'nullable|string|max:30|unique:data_siswa,nis',
        'nisn'             => 'nullable|string|max:30|unique:data_siswa,nisn',
        'jenis_kelamin_id' => 'required|exists:jenis_kelamins,id',  // ✅
        'tempat_lahir'     => 'nullable|string|max:100',
        'tanggal_lahir'    => 'nullable|date',
        'agama_id'         => 'nullable|exists:agamas,id',
        'agama_lainnya'    => 'required_without:agama_id|nullable|string|max:50',
        'alamat'           => 'nullable|string',
        'rombel_id'        => 'nullable|exists:rombels,id',
        'password'         => 'nullable|string|min:6|confirmed',
    ]);

    DB::beginTransaction();
    try {
        $userId = null;
        if (!empty($data['nis'])) {
            $user = User::create([
                'name'         => $data['nama_lengkap'],
                'email'        => $data['nis'] . '@siswa.sch.id',
                'password'     => Hash::make($data['nis'] . '123'),
                'role'         => 'siswa',
                'nomor_induk'  => $data['nis'],
            ]);
            $userId = $user->id;
        }

        DataSiswa::create([
            'user_id'          => $userId,
            'nama_lengkap'     => $data['nama_lengkap'],
            'nis'              => $data['nis'] ?? null,
            'nisn'             => $data['nisn'] ?? null,
            'jenis_kelamin_id' => $data['jenis_kelamin_id'],  // ✅
            'tempat_lahir'     => $data['tempat_lahir'] ?? null,
            'tanggal_lahir'    => $data['tanggal_lahir'] ?? null,
            'agama_id'         => $data['agama_id'] ?? null,
            'agama_lainnya'    => $isAgamaLainnya ? $data['agama_lainnya'] : null,
            'alamat'           => $data['alamat'] ?? null,
            'rombel_id'        => $data['rombel_id'] ?? null,
        ]);

        DB::commit();
        return redirect()->route('tu.siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}    public function siswaDetail($id)
    {
        $siswa = DataSiswa::with(['user', 'nilaiRaports', 'rombel.kelas'])->findOrFail($id);
        return view('tu.siswa.data-diri.show', compact('siswa'));
    }

    public function siswaEdit($id)
    {
        $siswa = DataSiswa::with(['rombel.kelas', 'agama'])->findOrFail($id);
        
        $jurusans = Jurusan::all();
        $rombels = Rombel::all();
        $kelas = Kelas::with('jurusan')->get();
        $jenisKelamins = JenisKelamin::all();
        $agamas = Agama::all();
        
        return view('tu.siswa.edit', compact('siswa', 'jurusans', 'rombels', 'kelas', 'jenisKelamins', 'agamas'));
    }

    public function siswaUpdate(Request $request, $id)
    {
        $siswa = DataSiswa::findOrFail($id);

        $isAgamaLainnya = $request->input('agama_id') === 'other';

        if ($isAgamaLainnya) {
            $request->merge(['agama_id' => null]);
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'nullable|string|max:20|unique:data_siswa,nis,' . $id,
            'nisn' => 'nullable|string|max:20|unique:data_siswa,nisn,' . $id,
            'jenis_kelamin_id' => 'required|exists:jenis_kelamins,id',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'agama_id' => 'nullable|exists:agamas,id',
            'agama_lainnya' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:30',
            'rombel_id' => 'nullable|exists:rombels,id',
            'alamat' => 'nullable|string',
            'tanggal_diterima' => 'nullable|date',
            'email' => 'nullable|email|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'ayah_nama' => 'nullable|string|max:255',
            'ayah_pekerjaan' => 'nullable|string|max:255',
            'ayah_telepon' => 'nullable|string|max:30',
            'ibu_nama' => 'nullable|string|max:255',
            'ibu_pekerjaan' => 'nullable|string|max:255',
            'ibu_telepon' => 'nullable|string|max:30',
            'wali_nama' => 'nullable|string|max:255',
            'wali_pekerjaan' => 'nullable|string|max:255',
            'wali_telepon' => 'nullable|string|max:30',
            'wali_alamat' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $siswa->update([
                'nama_lengkap' => $request->nama_lengkap,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'jenis_kelamin_id' => $request->jenis_kelamin_id,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama_id' => $isAgamaLainnya ? null : $request->agama_id,
                'agama_lainnya' => $isAgamaLainnya ? $request->agama_lainnya : null,
                'no_hp' => $request->no_hp,
                'rombel_id' => $request->rombel_id,
                'alamat' => $request->alamat,
                'tanggal_diterima' => $request->tanggal_diterima,
                'nama_ayah' => $request->ayah_nama,
                'pekerjaan_ayah' => $request->ayah_pekerjaan,
                'telepon_ayah' => $request->ayah_telepon,
                'nama_ibu' => $request->ibu_nama,
                'pekerjaan_ibu' => $request->ibu_pekerjaan,
                'telepon_ibu' => $request->ibu_telepon,
                'nama_wali' => $request->wali_nama,
                'pekerjaan_wali' => $request->wali_pekerjaan,
                'telepon_wali' => $request->wali_telepon,
                'alamat_wali' => $request->wali_alamat,
            ]);

            if ($siswa->user) {
                $siswa->user->name = $request->nama_lengkap;
                $siswa->user->nomor_induk = $request->nis;
                if ($request->filled('email')) {
                    $siswa->user->email = $request->email;
                }
                if ($request->filled('nis')) {
                    $siswa->user->nomor_induk = $request->nis;
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

    public function siswaExportPdf($id)
    {
        $siswa = DataSiswa::with([
            'rombel.kelas', 
            'agama', 
            'jenisKelamin'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('tu.siswa.data-diri.pdf', compact('siswa'))
            ->setPaper('A4', 'portrait');

        $filename = 'Data_Diri_' . ($siswa->nama_lengkap ?? $siswa->nis ?? $siswa->id) . '.pdf';

        return $pdf->stream($filename);
    }

    public function exportSiswa(Request $request)
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
        return Excel::download(new SiswaAktifExport(), 'siswa_aktif.xlsx');
    }

    public function exportSiswaByAngkatan($jurusanId)
    {
        $jurusan = Jurusan::findOrFail($jurusanId);
        $filename = 'Data_Siswa_Per_Angkatan_' . $jurusan->nama . '.xlsx';
        return Excel::download(new KaprogSiswaByAngkatanExport($jurusanId, $jurusan->nama), $filename);
    }

    public function exportSiswaByRombel($rombelId)
    {
        $rombel = Rombel::findOrFail($rombelId);
        $filename = 'Data_Siswa_Rombel_' . $rombel->nama . '.xlsx';
        return Excel::download(new KaprogSiswaByRombelExport($rombelId, $rombel->nama), $filename);
    }

    protected function buildSiswaExportFilename(array $filters): string
    {
        $parts = [];
        if (!empty($filters['search'])) $parts[] = 'pencarian_' . $filters['search'];
        if (!empty($filters['rombel'])) {
            $rombel = Rombel::find($filters['rombel']);
            $parts[] = 'kelas_' . ($rombel?->nama ?? $filters['rombel']);
        }
        if (!empty($filters['tingkat'])) $parts[] = 'kelas_' . $filters['tingkat'];
        if (!empty($filters['jurusan'])) $parts[] = 'jurusan_' . $filters['jurusan'];
        if (!empty($filters['status'])) $parts[] = $filters['status'];
        if (empty($parts)) return 'siswa_semua.xlsx';
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

    public function guruCreate()
    {
        $jurusans = Jurusan::orderBy('nama')->get();
        $kelas = Kelas::with('jurusan')->orderBy('tingkat')->get();
        $rombels = Rombel::with(['kelas.jurusan'])->orderBy('nama')->get();

        $kelasArr = $kelas->map(function($k){
            return ['value' => (string) $k->id, 'text' => $k->tingkat . ' - ' . ($k->jurusan->nama ?? ''), 'jurusan' => (string) ($k->jurusan_id ?? '')];
        });

        $rombelArr = $rombels->map(function($r){
            return ['value' => (string) $r->id, 'text' => $r->nama, 'kelas' => (string) ($r->kelas_id ?? '')];
        });

        $roles = ['walikelas' => 'Guru', 'kaprog' => 'Kaprog', 'tu' => 'TU', 'kurikulum' => 'Kurikulum'];

        return view('tu.guru.create', compact('jurusans', 'kelas', 'rombels', 'roles', 'kelasArr', 'rombelArr'));
    }

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

    public function guruShow($id)
    {
        $guru = Guru::with(['user', 'rombels.kelas.jurusan'])->findOrFail($id);
        return view('tu.guru.show', compact('guru'));
    }

    public function guruEdit($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        $jurusans = Jurusan::orderBy('nama')->get();
        $kelas = Kelas::with('jurusan')->orderBy('tingkat')->get();
        $rombels = Rombel::with(['kelas.jurusan'])->orderBy('nama')->get();

        $kelasArr = $kelas->map(function ($k) {
            return ['value' => (string) $k->id, 'text' => $k->tingkat . ' - ' . ($k->jurusan->nama ?? ''), 'jurusan' => (string) ($k->jurusan_id ?? '')];
        });

        $rombelArr = $rombels->map(function ($r) {
            return ['value' => (string) $r->id, 'text' => $r->nama, 'kelas' => (string) ($r->kelas_id ?? '')];
        });

        $roles = ['walikelas' => 'Guru', 'kaprog' => 'Kaprog', 'tu' => 'TU', 'kurikulum' => 'Kurikulum'];

        return view('tu.guru.edit', compact('guru', 'jurusans', 'kelas', 'rombels', 'roles', 'kelasArr', 'rombelArr'));
    }

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
        if (!empty($data['password'])) $user->password = bcrypt($data['password']);
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

    public function guruDestroy($id)
    {
        $guru = Guru::findOrFail($id);
        if ($guru->user) $guru->user->delete();
        $guru->delete();
        return redirect()->route('tu.guru.index')->with('success', 'Guru berhasil dihapus');
    }

    public function exportGuru()
    {
        return Excel::download(new GuruExportMultiSheet(), 'Pengguna_Guru.xlsx');
    }

    public function kelas()
    {
        $search = request('search');
        $jurusan_id = request('jurusan');
        
        $rombels = Rombel::with(['kelas.jurusan', 'guru', 'konsentrasiKeahlian'])
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
        $allRombels = Rombel::with(['kelas.jurusan', 'guru', 'konsentrasiKeahlian'])->orderBy('nama')->get();

        return view('tu.kelas.index', compact('rombels', 'allJurusans', 'search', 'jurusan_id', 'allRombels'));
    }

    public function kelasCreate()
    {
        $jurusans = Jurusan::all();
        $tingkats = ['X','XI','XII'];
        $gurus = Guru::all();
        $konsentrasiKeahlians = \App\Models\KonsentrasiKeahlian::all();
        return view('tu.kelas.create', compact('jurusans','tingkats','gurus', 'konsentrasiKeahlians'));
    }

    public function kelasStore(Request $request)
    {
        $request->validate([
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusans,id',
            'id_konke' => 'nullable|exists:konsentrasi_keahlian,id',
        ]);
        Kelas::create($request->only(['tingkat','jurusan_id','nama']));
        return redirect()->route('tu.kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function kelasShow($id)
    {
        $rombel = Rombel::with([
            'kelas.jurusan',
            'guru',
            'konsentrasiKeahlian',
            'siswa' => function($query) {
                $query->orderBy('nama_lengkap', 'asc');
            },
            'siswa.jenisKelamin'
        ])->findOrFail($id);

        return view('tu.kelas.show', compact('rombel'));
    }

    public function kelasDetail(Request $request, $id)
    {
        $rombel = Rombel::with(['kelas.jurusan', 'guru', 'konsentrasiKeahlian', 'siswa' => function($query) {
            $query->with([]);
        }])->find($id);

        if ($rombel) {
            return view('tu.kelas.show', compact('rombel'));
        }

        $kelas = Kelas::with(['jurusan', 'rombels.guru', 'rombels.konsentrasiKeahlian'])->findOrFail($id);
        $rombels = $kelas->rombels ?? collect();
        return view('tu.kelas.detail_kelas', compact('kelas', 'rombels'));
    }

    public function kelasEdit($id)
    {
        $rombel = Rombel::with(['kelas.jurusan', 'guru', 'konsentrasiKeahlian'])->findOrFail($id);
        $jurusans = Jurusan::all();
        $gurus = Guru::all();
        $tingkats = ['X','XI','XII'];
        $konsentrasiKeahlians = \App\Models\KonsentrasiKeahlian::all();
        return view('tu.kelas.edit', compact('rombel', 'jurusans', 'gurus', 'tingkats', 'konsentrasiKeahlians'));
    }

    public function kelasUpdate(Request $request, $id)
    {
        $rombel = Rombel::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'guru_id' => 'required|exists:gurus,id',
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusans,id',
            'id_konke' => 'nullable|exists:konsentrasi_keahlian,id',
        ]);
        
        $rombel->update([
            'nama' => $request->nama,
            'guru_id' => $request->guru_id,
            'id_konke' => $request->id_konke,
        ]);
        
        $rombel->kelas->update($request->only(['tingkat', 'jurusan_id']));
        
        return redirect()->route('tu.kelas.show', $id)->with('success', 'Data rombel berhasil diperbarui.');
    }

    public function kelasDestroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return redirect()->route('tu.kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }

    public function exportKelasAll()
    {
        return Excel::download(new KelasExport(), 'kelas_all.xlsx');
    }

    public function downloadKelasTemplate()
    {
        return Excel::download(new KelasImportTemplate(), 'Template_Import_Rombel.xlsx');
    }

    public function importKelas(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            $import = new KelasImport();
            Excel::import($import, $request->file('file'));

            $successCount = $import->getSuccessCount();
            $createdCount = $import->getCreatedCount();
            $updatedCount = $import->getUpdatedCount();
            $errors = $import->getErrors();
            $processedRows = $import->getProcessedRows();

            $message = "✅ Import selesai! ";
            $message .= "Berhasil: {$successCount} data ";
            if ($createdCount > 0) {
                $message .= "({$createdCount} baru, ";
            }
            if ($updatedCount > 0) {
                $message .= "{$updatedCount} update) ";
            }
            $message .= "dari {$processedRows} baris yang diproses.";

            if (count($errors) > 0) {
                $errorMessage = "⚠️ Terdapat " . count($errors) . " peringatan/error:\n" . implode("\n", array_slice($errors, 0, 10));
                if (count($errors) > 10) {
                    $errorMessage .= "\n... dan " . (count($errors) - 10) . " error lainnya.";
                }
                return redirect()->route('tu.kelas.index')
                    ->with('success', $message)
                    ->with('import_warnings', $errors);
            }

            return redirect()->route('tu.kelas.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            Log::error('Kelas import error', ['error' => $e->getMessage()]);
            return redirect()->route('tu.kelas.index')
                ->with('error', '❌ Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function kelasExport($id, Request $request)
    {
        $rombel = Rombel::findOrFail($id);
        $bulan = $request->query('bulan', date('F Y'));
        
        $filename = 'Daftar_Hadir_' . str_replace([' ', '/'], ['_', '-'], $rombel->nama) . '.xlsx';
        
        return Excel::download(new DaftarHadirExport($id, $bulan), $filename);
    }

    public function printAbsensi($id)
    {
        $rombel = Rombel::with([
            'kelas.jurusan',
            'guru',
            'konsentrasiKeahlian',
            'siswa' => function($query) {
                $query->orderBy('nama_lengkap', 'asc');
            },
            'siswa.jenisKelamin',
            'siswa.absensi'
        ])->findOrFail($id);

        $semester = Semester::with('tahunAjaran')->where('is_active', true)->first();
        if (!$semester) {
            $semester = Semester::with('tahunAjaran')->orderBy('id', 'desc')->first();
        }

        $tahunAjaran = optional($semester)->tahunAjaran;

        $jumlahLaki = $rombel->siswa->filter(function ($siswa) {
            $jenis = optional($siswa->jenisKelamin)->nama ?? $siswa->jenis_kelamin ?? '';
            $jenis = strtolower(trim($jenis));
            return in_array($jenis, ['laki-laki', 'l', 'male', 'laki']);
        })->count();

        $jumlahPerempuan = $rombel->siswa->filter(function ($siswa) {
            $jenis = optional($siswa->jenisKelamin)->nama ?? $siswa->jenis_kelamin ?? '';
            $jenis = strtolower(trim($jenis));
            return in_array($jenis, ['perempuan', 'p', 'female', 'perempuan']);
        })->count();

        $kepalaSekolah = Guru::first();
        if (!$kepalaSekolah) {
            $kepalaSekolah = (object) ['nama' => 'DEDE FAJRIADI, S.Pd., M.Pd.', 'nip' => '19840222 20090 1 1005'];
        }

        $siswa = $rombel->siswa;
        $bulan = request()->query('bulan', date('F Y'));

        return view('tu.kelas.print-absensi', compact(
            'rombel', 'semester', 'tahunAjaran', 'jumlahLaki',
            'jumlahPerempuan', 'kepalaSekolah', 'siswa', 'bulan'
        ));
    }

    public function waliKelas()
    {
        $waliKelas = Guru::with(['user', 'kelas', 'jurusan', 'rombels'])->latest()->paginate(10);
        $jurusans = Jurusan::with(['gurus.user', 'gurus.kelas'])->get();
        return view('tu.wali-kelas.index', compact('waliKelas', 'jurusans'));
    }

    public function waliKelasDetail($id)
    {
        $waliKelas = Guru::with(['user', 'kelas', 'jurusan', 'rombels'])->findOrFail($id);
        return view('tu.wali-kelas.show', compact('waliKelas'));
    }

    public function waliKelasCreate()
    {
        // Implementasi create wali kelas
    }

    public function waliKelasStore(Request $request)
    {
        // Implementasi store wali kelas
    }

    public function waliKelasEdit($id)
    {
        // Implementasi edit wali kelas
    }

    public function waliKelasUpdate(Request $request, $id)
    {
        // Implementasi update wali kelas
    }

    public function waliKelasDestroy($id)
    {
        // Implementasi destroy wali kelas
    }

    public function laporanNilai()
    {
        $nilaiRaports = NilaiRaport::with(['siswa' => function($query) {
            $query->with([]);
        }])->orderBy('tahun_ajaran', 'desc')->orderBy('semester', 'desc')->paginate(20);
        return view('tu.laporan-nilai', compact('nilaiRaports'));
    }

public function cetakBiodataAll(Request $request)
{
    $rombelId = $request->input('rombel_id');

    if (!$rombelId) {
        return redirect()->back()->with('error', 'Silakan pilih rombel terlebih dahulu.');
    }

    // 🔥 AMBIL SISWA TANPA FILTER TAHUN AJARAN
    $siswa = \App\Models\DataSiswa::where('rombel_id', $rombelId)
        ->with(['rombel.kelas.jurusan', 'agama'])
        ->get();

    $rombel = \App\Models\Rombel::find($rombelId);
    $tahunAjaran = $request->input('tahun_ajaran', 'Semua Tahun');

    // 🔥 PAKAI DomPDF
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('tu.laporan.pdf.biodata-all', compact('siswa', 'rombelId', 'tahunAjaran', 'rombel'));
    
    $pdf->setPaper('F4', 'portrait');
    
    // 🔥 NAMA FILE - BERSIHKAN SEMUA KARAKTER ILEGAL
    $rombelName = preg_replace('/[^a-zA-Z0-9\-_]/', '-', $rombel->nama ?? 'semua');
    $tahunClean = preg_replace('/[^a-zA-Z0-9\-_]/', '-', $tahunAjaran);
    $fileName = 'biodata-siswa-' . $rombelName . '-' . $tahunClean . '.pdf';
    
    return $pdf->download($fileName);
}
      public function cetakDaftarHadirRapot()
    {
        $rombelId = request('rombel_id');

        if (!$rombelId) {
            return redirect()->back()->with('error', 'Silakan pilih rombel terlebih dahulu.');
        }

        $rombel = Rombel::with(['siswa', 'siswa.absensi'])->findOrFail($rombelId);

        // Ambil semester aktif (yang is_current paling diprioritaskan)
        $semester = Semester::with('tahunAjaran')
            ->where('is_current', true)
            ->first();

        if (!$semester) {
            $semester = Semester::with('tahunAjaran')
                ->where('is_active', true)
                ->orderBy('id', 'desc')
                ->first();
        }

        if (!$semester) {
            $semester = Semester::with('tahunAjaran')
                ->orderBy('id', 'desc')
                ->first();
        }

        // Ambil tahun ajaran dari relasi (bukan dari kolom $semester->tahun yang tidak ada)
        $tahunAjaran = $semester?->tahunAjaran?->tahun;

        // Fallback: kalau masih null, cari tahun ajaran yang is_current
        if (empty($tahunAjaran)) {
            $tahunAjaran = \App\Models\TahunAjaran::where('is_current', true)->value('tahun');
        }

        // Fallback terakhir: tahun ajaran terbaru (order by tahun desc)
        if (empty($tahunAjaran)) {
            $tahunAjaran = \App\Models\TahunAjaran::orderBy('tahun', 'desc')->value('tahun');
        }

        $pdf = Pdf::loadView('tu.laporan.pdf.daftar-hadir-rapot', [
            'rombel' => $rombel,
            'siswa' => $rombel->siswa,
            'semester' => $semester,
            'tahunAjaran' => $tahunAjaran,
        ]);
        $pdf->setPaper('F4', 'portrait');

        return $pdf->stream('daftar-hadir-rapot.pdf');
    }
    public function cetakSuratAktif($siswa_id)
    {
        $siswa = DataSiswa::with(['rombel.kelas.jurusan'])->findOrFail($siswa_id);
        
        $kepalaSekolah = Guru::first();
        if (!$kepalaSekolah) {
            $kepalaSekolah = (object) [
                'nama' => 'DEDE FAIRIADI, S.Pd., M.Pd.',
                'nip' => '19640222 20090 1 1 005'
            ];
        }

        $tanggal = date('d F Y');
        $tahunPelajaran = date('Y') . '/' . (date('Y') + 1);

        $tahun = date('Y');
        $nomorUrut = NomorSurat::getNextNumber('surat_aktif', $tahun);
        $nomorSuratText = sprintf('421.7/%03d/SMK.1.KW/%s', $nomorUrut, $tahun);

        return view('tu.laporan.pdf.surat-aktif', compact(
            'siswa', 
            'kepalaSekolah', 
            'tanggal', 
            'nomorSuratText', 
            'tahunPelajaran'
        ));
    }

    public function cetakSuratAktifPdf($siswa_id)
    {
        $siswa = DataSiswa::with(['rombel.kelas.jurusan'])->findOrFail($siswa_id);
        
        $kepalaSekolah = Guru::first();
        if (!$kepalaSekolah) {
            $kepalaSekolah = (object) [
                'nama' => 'DEDE FAIRIADI, S.Pd., M.Pd.',
                'nip' => '19640222 20090 1 1 005'
            ];
        }

        $tanggal = date('d F Y');
        $tahunPelajaran = date('Y') . '/' . (date('Y') + 1);

        $tahun = date('Y');
        $nomorUrut = NomorSurat::getNextNumber('surat_aktif', $tahun);
        $nomorSuratText = sprintf('421.7/%03d/SMK.1.KW/%s', $nomorUrut, $tahun);

        $pdf = Pdf::loadView('tu.laporan.pdf.surat-aktif', compact(
            'siswa', 
            'kepalaSekolah', 
            'tanggal', 
            'nomorSuratText', 
            'tahunPelajaran'
        ));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('surat-keterangan-aktif-'.$siswa->nis.'.pdf');
    }

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

    public function nilaiRaportShow(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $semester = $request->semester;
        $tahunParam = $request->tahun;
        $tahun = is_string($tahunParam) ? trim(str_replace('-', '/', $tahunParam)) : $tahunParam;

        if (!$siswa_id || !$semester || !$tahun) abort(404, "Parameter tidak lengkap.");

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

    public function nilaiRaportEdit(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $semester = $request->semester;
        $tahunParam = $request->tahun;
        $tahun = is_string($tahunParam) ? trim(str_replace('-', '/', $tahunParam)) : $tahunParam;

        if (!$siswa_id || !$semester || !$tahun) abort(404, "Parameter tidak lengkap.");

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
                            $q->whereDoesntHave('jurusans')->orWhereHas('jurusans', function($jq) use ($currentJurusanId) {
                                $jq->where('jurusan_id', $currentJurusanId);
                            });
                        });
                        $kelompokB = $kelompokB->where(function($q) use ($currentJurusanId) {
                            $q->whereDoesntHave('jurusans')->orWhereHas('jurusans', function($jq) use ($currentJurusanId) {
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

    public function nilaiRaportUpdate(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $semester = $request->semester;
        $tahunParam = $request->tahun;
        $tahun = is_string($tahunParam) ? str_replace('-', '/', $tahunParam) : $tahunParam;

        if (!$siswa_id || !$semester || !$tahun) abort(404, "Parameter tidak lengkap.");

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

                if (!$existing && !$hasNilai && !$hasDeskripsi) continue;

                if ($existing) {
                    $existing->nilai_akhir = $hasNilai ? $value['nilai_akhir'] : ($existing->nilai_akhir ?? null);
                    $existing->deskripsi = $hasDeskripsi ? $value['deskripsi'] : ($existing->deskripsi ?? null);
                    if (empty($existing->rombel_id)) $existing->rombel_id = $siswa->rombel_id ?? null;
                    if (empty($existing->kelas_id)) $existing->kelas_id = $siswa->rombel && $siswa->rombel->kelas ? $siswa->rombel->kelas->id : null;
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

    public function nilaiRaportDestroy($id)
    {
        // Implementasi destroy nilai raport
    }

    public function nilaiRaportIndex(Request $request)
    {
        // Implementasi index nilai raport
    }

    public function downloadTemplate()
    {
        return Excel::download(new SiswaImportTemplate(), 'template-siswa.xlsx');
    }

    public function downloadSiswaTemplate()
    {
        return Excel::download(new SiswaImportTemplate(), 'Template_Import_Siswa_SMKN1Kawali.xlsx');
    }

    public function importSiswa(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            $this->backupDataSiswa();

            $import = new SiswaImport();
            Excel::import($import, $request->file('file'));

            $successCount = $import->getSuccessCount();
            $updatedCount = $import->getUpdatedCount();
            $errors = $import->getErrors();
            $processedRows = $import->getProcessedRows();
            $skippedEmpty = $import->getSkippedEmptyRows();

            $message = "✅ Import selesai! ";
            $message .= "Berhasil: {$successCount} data ";
            if ($updatedCount > 0) {
                $message .= "({$updatedCount} update) ";
            }
            $message .= "dari {$processedRows} baris yang diproses.";
            if ($skippedEmpty > 0) {
                $message .= " ({$skippedEmpty} baris kosong dilewati)";
            }

            if (count($errors) > 0) {
                $errorMessage = "⚠️ Terdapat " . count($errors) . " peringatan/error:\n" . implode("\n", array_slice($errors, 0, 10));
                if (count($errors) > 10) {
                    $errorMessage .= "\n... dan " . (count($errors) - 10) . " error lainnya.";
                }
                return redirect()->route('tu.siswa.index')
                    ->with('success', $message)
                    ->with('import_warnings', $errors);
            }

            return redirect()->route('tu.siswa.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Siswa import error', [
                'error' => $e->getMessage(),
                'file' => $request->file('file')->getClientOriginalName()
            ]);
            return redirect()->route('tu.siswa.index')
                ->with('error', '❌ Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function backupDataSiswa()
    {
        $siswa = DataSiswa::with(['user', 'rombel'])->get();
        $filename = 'siswa_before_import_' . date('Y-m-d_H-i-s') . '.json';
        $path = storage_path('app/backup/' . $filename);
        
        if (!is_dir(storage_path('app/backup'))) {
            mkdir(storage_path('app/backup'), 0777, true);
        }
        
        file_put_contents($path, $siswa->toJson(JSON_PRETTY_PRINT));
        Log::info("Backup siswa saved to: {$path}");
    }

    public function downloadLegerTemplate(Request $request)
    {
        $request->validate([
            'rombel_id' => 'required|exists:rombels,id',
            'semester' => 'required|in:1,2',
            'tahun_ajaran' => 'required|string',
        ]);

        $rombel = Rombel::findOrFail($request->rombel_id);
        $rombelName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $rombel->nama);
        $tahunAjaranClean = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $request->tahun_ajaran);

        $export = new LegerTemplate($request->rombel_id, $request->semester, $request->tahun_ajaran);
        $filename = "Leger_{$rombelName}_Sem{$request->semester}_{$tahunAjaranClean}.xlsx";

        return Excel::download($export, $filename);
    }

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

    public function exportByKelas(Request $request)
    {
        $rombelId = $request->query('rombel');
        if (!$rombelId) {
            return redirect()->back()->with('error', 'Silakan pilih kelas terlebih dahulu.');
        }

        $rombel = Rombel::findOrFail($rombelId);
        $siswa = DataSiswa::where('rombel_id', $rombelId)->get();

        return Excel::download(new SiswaExport(['rombel' => $rombelId]), 'siswa_kelas_' . $rombel->nama . '.xlsx');
    }

    public function exportByJurusan(Request $request)
    {
        $jurusanId = $request->query('jurusan');
        if (!$jurusanId) {
            return redirect()->back()->with('error', 'Silakan pilih jurusan terlebih dahulu.');
        }

        $jurusan = Jurusan::findOrFail($jurusanId);
        $siswa = DataSiswa::whereHas('rombel.kelas', function($q) use ($jurusanId) {
            $q->where('jurusan_id', $jurusanId);
        })->get();

        return Excel::download(new SiswaExport(['jurusan' => $jurusanId]), 'siswa_jurusan_' . $jurusan->nama . '.xlsx');
    }

    public function exportAktif(Request $request)
    {
        $siswa = DataSiswa::whereHas('rombel')->get();
        return Excel::download(new SiswaAktifExport(), 'siswa_aktif.xlsx');
    }
    
}