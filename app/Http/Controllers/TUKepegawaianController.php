<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guru;
use App\Models\Pegawai;
use App\Models\Jurusan;
use App\Models\Kurikulum;
use App\Models\MataPelajaran;
use App\Models\Mutasi;
use App\Models\RiwayatTugas;
use App\Models\MutasiPegawai;
use App\Models\RiwayatKerja;
use App\Models\Dokumen;
use App\Models\TugasTambahan;
use App\Imports\GuruImport;
use App\Exports\GuruTemplateExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TUKepegawaianController extends Controller
{
    // ==========================================================
    // PROPERTIES & HELPERS
    // ==========================================================

    private function riwayatTableAvailable(): bool
    {
        return Schema::hasTable('riwayat_kerjas');
    }

    private function riwayatTugasTableAvailable(): bool
    {
        return Schema::hasTable('riwayat_tugas');
    }

    private function mutasiTableAvailable(): bool
    {
        return Schema::hasTable('mutasis');
    }

    private function mutasiPegawaiTableAvailable(): bool
    {
        return Schema::hasTable('mutasi_pegawais');
    }

    protected static $guruTemplateFields = [
        'nama' => 'Nama',
        'nik' => 'NIK',
        'nuptk' => 'NUPTK',
        'nip' => 'NIP',
        'status_kepegawaian' => 'Status Kepegawaian',
        'jenis_kelamin' => 'Jenis Kelamin',
        'pendidikan' => 'Pendidikan',
        'serdik' => 'Serdik',
        'tempat_lahir' => 'Tempat Lahir',
        'tanggal_lahir' => 'Tanggal Lahir',
        'email_pribadi' => 'Email Pribadi',
        'email_resmi' => 'Email Resmi',
        'alamat_jalan' => 'Alamat',
        'rt' => 'RT',
        'rw' => 'RW',
        'dusun' => 'Dusun',
        'desa' => 'Desa/Kelurahan',
        'kecamatan' => 'Kecamatan',
        'kode_pos' => 'Kode Pos',
        'telepon' => 'No HP',
    ];

    private static $guruColumnsCache = null;

    private function guruDataFromRequest(Request $request): array
    {
        $fields = [
            'nama', 'nik', 'nuptk', 'nip',
            'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
            'status_kepegawaian', 'status_aktif', 'pendidikan', 'serdik',
            'telepon', 'no_hp', 'email', 'email_pribadi', 'email_resmi',
            'alamat', 'alamat_jalan', 'rt', 'rw', 'dusun', 'desa',
            'kecamatan', 'kode_pos', 'jurusan_id', 'gelar_belakang',
            'gelar_depan',
        ];

        $data = $request->only($fields);

        if (self::$guruColumnsCache === null) {
            self::$guruColumnsCache = Schema::getColumnListing('gurus');
        }
        $guruColumns = self::$guruColumnsCache;

        $aliases = [
            'alamat_jalan' => 'alamat',
            'alamat'       => 'alamat_jalan',
            'no_hp'        => 'telepon',
            'telepon'      => 'no_hp',
            'email_pribadi' => 'email',
        ];
        foreach ($aliases as $from => $to) {
            if (isset($data[$from]) && !in_array($from, $guruColumns) && in_array($to, $guruColumns)) {
                if (!isset($data[$to])) {
                    $data[$to] = $data[$from];
                }
                unset($data[$from]);
            }
        }

        if (isset($data['kelurahan']) && !in_array('kelurahan', $guruColumns)) {
            if (!isset($data['desa']) || empty($data['desa'])) {
                $data['desa'] = $data['kelurahan'];
            }
            unset($data['kelurahan']);
        }

        return array_filter($data, function ($value, $key) use ($guruColumns) {
            return in_array($key, $guruColumns);
        }, ARRAY_FILTER_USE_BOTH);
    }

    // ==========================================================
    // DASHBOARD
    // ==========================================================
        public function dashboard()
    {
        // ==========================================================
        // DATA INTI
        // ==========================================================
        $totalGuru          = Guru::count();
        $pegawaiTableExists = Schema::hasTable('pegawais');

        if ($pegawaiTableExists) {
            $totalTU             = Pegawai::where('jabatan', 'tu')->count();
            $totalTUKepegawaian  = Pegawai::where('jabatan', 'tu_kepegawaian')->count();
            $totalPegawai        = Pegawai::count();
            $totalPegawaiLainnya = max(0, $totalPegawai - $totalTU - $totalTUKepegawaian);
            $totalStaffAktif     = $totalGuru + $totalPegawai;
        } else {
            $totalTU             = User::where('role', 'tu')->count();
            $totalTUKepegawaian  = User::where('role', 'tu_kepegawaian')->count();
            $totalPegawai        = User::whereIn('role', ['tu', 'tu_kepegawaian'])->count();
            $totalPegawaiLainnya = 0;
            $totalStaffAktif     = $totalGuru + $totalPegawai;
        }

        $guruBaru = Guru::with('user')->latest()->take(5)->get();

        // ==========================================================
        // REKAP STATUS KEPEGAWAIAN
        // ==========================================================
        $hitungStatus = function ($query, string $status) {
            return (clone $query)
                ->whereRaw("LOWER(TRIM(status_kepegawaian)) = ?", [strtolower($status)])
                ->count();
        };

        $guruQuery          = Guru::query();
        $totalGuruPNS       = $hitungStatus($guruQuery, 'PNS');
        $totalGuruPPPK      = $hitungStatus($guruQuery, 'PPPK');
        $totalGuruPPPKParuh = $hitungStatus($guruQuery, 'PPPK Paruh Waktu');

        if ($pegawaiTableExists) {
            $tuQuery         = Pegawai::query();
            $totalTUPNS      = $hitungStatus($tuQuery, 'PNS');
            $totalTUPPPK     = $hitungStatus($tuQuery, 'PPPK');
            $totalTUPPKParuh = $hitungStatus($tuQuery, 'PPPK Paruh Waktu');
        } else {
            $totalTUPNS      = 0;
            $totalTUPPPK     = 0;
            $totalTUPPKParuh = 0;
        }

        // ==========================================================
        // STATISTIK KARTU DASHBOARD
        // ==========================================================

        // 1. Guru aktif vs nonaktif
        $guruAktif = 0;
        if (Schema::hasColumn('gurus', 'status_keaktifan')) {
            $guruAktif = Guru::whereRaw("LOWER(TRIM(status_keaktifan)) = 'aktif'")->count();
        }
        $guruNonaktif = max(0, $totalGuru - $guruAktif);

        // 2. Gender guru
        $guruLakiLaki  = Guru::where('jenis_kelamin', 'L')->count();
        $guruPerempuan = Guru::where('jenis_kelamin', 'P')->count();

        // 3. Ditambahkan bulan ini
        $guruBulanIni = Guru::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $pegawaiBulanIni = 0;
        if ($pegawaiTableExists) {
            $pegawaiBulanIni = Pegawai::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();
        }

        // 4. Ditambahkan 6 bulan terakhir
        $batas6Bulan = now()->subMonthsNoOverflow(6)->startOfDay();

        $masuk6BulanGuru = Guru::where('created_at', '>=', $batas6Bulan)->count();

        $masuk6BulanPegawai = 0;
        if ($pegawaiTableExists) {
            $masuk6BulanPegawai = Pegawai::where('created_at', '>=', $batas6Bulan)->count();
        }

        // ==========================================================
        // KIRIM KE VIEW
        // ==========================================================
        return view('tu_kepegawaian.dashboard', compact(
            'totalGuru',
            'totalTU',
            'totalTUKepegawaian',
            'totalStaffAktif',
            'guruBaru',
            'totalPegawai',
            'totalPegawaiLainnya',
            'totalGuruPNS',
            'totalGuruPPPK',
            'totalGuruPPPKParuh',
            'totalTUPNS',
            'totalTUPPPK',
            'totalTUPPKParuh',
            'guruAktif',
            'guruNonaktif',
            'guruLakiLaki',
            'guruPerempuan',
            'guruBulanIni',
            'pegawaiBulanIni',
            'masuk6BulanGuru',
            'masuk6BulanPegawai'
        ));
    }

    // ==========================================================
    // DATA GURU
    // ==========================================================
    public function guruIndex(Request $request)
    {
        $query = Guru::with('user', 'jurusan')->orderBy('nama');
        $jurusans = Jurusan::orderBy('nama')->get();

        $roleOptions = [
            'guru' => 'Guru',
            'walikelas' => 'Wali Kelas',
            'kaprog' => 'Kaprog',
            'kurikulum' => 'Kurikulum'
        ];

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status_kepegawaian')) {
            $query->where('status_kepegawaian', $request->status_kepegawaian);
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('pendidikan')) {
            $query->where('pendidikan', $request->pendidikan);
        }

        $rekap = [
            'Total'   => (clone $query)->count(),
            'L'       => (clone $query)->where('jenis_kelamin', 'L')->count(),
            'P'       => (clone $query)->where('jenis_kelamin', 'P')->count(),
            'PNS'     => (clone $query)->where('status_kepegawaian', 'PNS')->count(),
            'PPPK'    => (clone $query)->where('status_kepegawaian', 'PPPK')->count(),
            'Honorer' => (clone $query)->where('status_kepegawaian', 'Honorer')->count(),
            'S1'      => (clone $query)->where('pendidikan', 'S1')->count(),
            'S2'      => (clone $query)->where('pendidikan', 'S2')->count(),
        ];

        $perPage = $request->input('per_page', 25);
        $gurus = ($perPage === 'all')
            ? $query->get()
            : $query->paginate(is_numeric($perPage) ? (int) $perPage : 25)->withQueryString();

        return view('tu_kepegawaian.guru.index', compact('gurus', 'jurusans', 'roleOptions', 'rekap'));
    }

    public function guruCreate()
    {
        $jurusans = Jurusan::orderBy('nama')->get();
        $roles = [
            'guru' => 'Guru',
            'walikelas' => 'Wali Kelas',
            'kaprog' => 'Kaprog',
            'kurikulum' => 'Kurikulum',
        ];

        return view('tu_kepegawaian.guru.create', compact('jurusans', 'roles'));
    }

    public function guruShow($id)
    {
        $guru = Guru::with(['user', 'jurusan', 'rombels.kelas.jurusan'])->findOrFail($id);
        return view('tu_kepegawaian.guru.show', compact('guru'));
    }

    public function guruEdit($id)
    {
        $guru = Guru::with(['user', 'jurusan'])->findOrFail($id);
        $jurusans = Jurusan::orderBy('nama')->get();
        $roles = [
            'guru' => 'Guru',
            'walikelas' => 'Wali Kelas',
            'kaprog' => 'Kaprog',
            'kurikulum' => 'Kurikulum',
        ];

        return view('tu_kepegawaian.guru.edit', compact('guru', 'jurusans', 'roles'));
    }

    public function guruStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
            'nuptk' => 'nullable|string|max:30',
            'nip' => 'nullable|string|max:30|unique:gurus,nip',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'email' => 'nullable|email',
            'email_pribadi' => 'nullable|email',
            'email_resmi' => 'nullable|email',
            'password' => 'nullable|min:6|confirmed',
            'status_kepegawaian' => 'nullable|in:PNS,PPPK,PPPK Paruh Waktu,Honorer,Guru Tetap Yayasan,Guru Tidak Tetap',
            'pendidikan' => 'nullable|in:S1,S2,S3,D4,D3',
            'gelar_belakang' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $userEmail = $request->input('email')
                ?? $request->input('email_pribadi')
                ?? $request->input('email_resmi');

            if (empty($userEmail)) {
                $userEmail = strtolower(str_replace(' ', '', $request->nama)) . time() . '@guru.sch.id';
            }

            $password = $request->filled('password')
                ? $request->password
                : ($request->filled('nip') ? $request->nip : '12345678');

            $user = User::create([
                'name' => $request->nama,
                'nomor_induk' => $request->nip,
                'email' => $userEmail,
                'password' => Hash::make($password),
                'role' => 'guru',
            ]);

            $data = $this->guruDataFromRequest($request);
            $data['user_id'] = $user->id;
            Guru::create($data);

            DB::commit();
            return redirect()->route('tu_kepegawaian.guru.index')->with('success', 'Data guru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function guruUpdate(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
            'nuptk' => 'nullable|string|max:30',
            'nip' => 'nullable|string|max:30|unique:gurus,nip,' . $guru->id,
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'email' => 'nullable|email',
            'email_pribadi' => 'nullable|email',
            'email_resmi' => 'nullable|email',
            'password' => 'nullable|min:6|confirmed',
            'status_kepegawaian' => 'nullable|in:PNS,PPPK,PPPK Paruh Waktu,Honorer,Guru Tetap Yayasan,Guru Tidak Tetap',
            'pendidikan' => 'nullable|in:S1,S2,S3,D4,D3',
            'gelar_belakang' => 'nullable|string|max:255',
        ]);

        if ($guru->user) {
            $dataUser = [
                'name' => $request->nama,
                'nomor_induk' => $request->filled('nip') ? $request->nip : $guru->user->nomor_induk,
            ];

            $userEmail = $request->input('email')
                ?? $request->input('email_pribadi')
                ?? $request->input('email_resmi');
            if (!empty($userEmail)) {
                $dataUser['email'] = $userEmail;
            }

            if ($request->filled('password')) {
                $dataUser['password'] = Hash::make($request->password);
            }

            $guru->user->update($dataUser);
        }

        $guru->update($this->guruDataFromRequest($request));

        return redirect()->route('tu_kepegawaian.guru.index')->with('success', 'Data guru berhasil diupdate.');
    }

    public function guruDestroy($id)
    {
        $guru = Guru::findOrFail($id);

        if ($guru->user_id) {
            User::where('id', $guru->user_id)->forceDelete();
        }

        $guru->forceDelete();

        return back()->with('success', 'Data guru berhasil dihapus permanen dari database.');
    }

    public function guruTemplate(Request $request)
    {
        $selected = $request->query('fields', array_keys(self::$guruTemplateFields));
        $fields = array_values(array_intersect(array_keys(self::$guruTemplateFields), (array)$selected));
        if (empty($fields)) {
            $fields = array_keys(self::$guruTemplateFields);
        }

        return Excel::download(new GuruTemplateExport($fields), 'guru_template.xlsx');
    }

    public function guruImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx,csv',
        ]);

        $selectedColumns = array_values(array_filter((array)$request->input('selected_columns', [])));
        $map = array_filter((array)$request->input('map', []), fn($value) => trim($value) !== '');

        $import = new GuruImport();
        if (!empty($selectedColumns)) {
            $import->setSelectedColumns($selectedColumns);
        }
        if (!empty($map)) {
            $import->setColumnMap($map);
        }

        Excel::import($import, $request->file('file'));

        $errors = $import->getErrors();
        $successCount = $import->getSuccessCount();

        if (!empty($errors)) {
            return back()->with('error', 'Import selesai dengan beberapa peringatan.')->with('import_errors', $errors);
        }

        return back()->with('success', "Import berhasil. {$successCount} baris diproses.");
    }

    // ==========================================================
    // BAGIAN DATA PEGAWAI (TU)
    // ==========================================================

    public function tuIndex(Request $request)
    {
        if (!Schema::hasTable('pegawais')) {
            return redirect()->route('tu_kepegawaian.dashboard')
                ->with('error', 'Tabel pegawai belum tersedia. Jalankan migrasi terlebih dahulu.');
        }

        $query = Pegawai::with('user')->orderBy('nama');

        $currentUserId = auth()->id();
        $query->where(function ($q) use ($currentUserId) {
            $q->whereNull('user_id')->orWhere('user_id', '!=', $currentUserId);
        });

        if ($request->filled('role')) {
            $query->where('jabatan', $request->role);
        }

        if ($request->filled('status_kepegawaian')) {
            $query->where('status_kepegawaian', $request->status_kepegawaian);
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('pendidikan')) {
            $query->where('pendidikan', $request->pendidikan);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $allPegawais = (clone $query)->get();

        $rekap = [
            'Total' => $allPegawais->count(),
            'L' => $allPegawais->where('jenis_kelamin', 'L')->count(),
            'P' => $allPegawais->where('jenis_kelamin', 'P')->count(),
        ];

        $statusList = $allPegawais->pluck('status_kepegawaian')->filter()->unique()->values();
        foreach ($statusList as $status) {
            $rekap[$status] = $allPegawais->where('status_kepegawaian', $status)->count();
        }

        $pendidikanList = $allPegawais->pluck('pendidikan')->filter()->unique()->values();
        foreach ($pendidikanList as $pendidikan) {
            $rekap[$pendidikan] = $allPegawais->where('pendidikan', $pendidikan)->count();
        }

        $perPage = $request->input('per_page', 25);
        $pegawais = ($perPage === 'all')
            ? $query->get()
            : $query->paginate(is_numeric($perPage) ? (int) $perPage : 25)->withQueryString();

        return view('tu_kepegawaian.tu.index', compact('pegawais', 'rekap'));
    }

    public function tuCreate()
    {
        return view('tu_kepegawaian.tu.create');
    }

    public function tuStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'nomor_induk' => 'required|string|unique:users,nomor_induk',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:tu,tu_kepegawaian',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'nomor_induk' => $request->nomor_induk,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ]);

            if (Schema::hasTable('pegawais')) {
                Pegawai::create([
                    'nama' => $request->name,
                    'nip' => $request->nomor_induk,
                    'nik' => $request->nik,
                    'nuptk' => $request->nuptk,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'status_kepegawaian' => $request->status_kepegawaian,
                    'pendidikan' => $request->pendidikan,
                    'email' => $request->email,
                    'no_hp' => $request->no_hp,
                    'jabatan' => $request->role,
                    'alamat' => $request->alamat,
                    'user_id' => $user->id,
                ]);
            }

            DB::commit();
            return redirect()->route('tu_kepegawaian.tu.index')->with('success', 'Akun dan Data Pegawai berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function tuShow($id)
    {
        if (Schema::hasTable('pegawais')) {
            $pegawai = Pegawai::with('user')->findOrFail($id);
            return view('tu_kepegawaian.tu.show', compact('pegawai'));
        }
        
        $user = User::findOrFail($id);
        return view('tu_kepegawaian.tu.show', compact('user'));
    }

    public function tuEdit($id)
    {
        if (Schema::hasTable('pegawais')) {
            $pegawai = Pegawai::with('user')->findOrFail($id);
            return view('tu_kepegawaian.tu.edit', compact('pegawai'));
        }
        
        $user = User::findOrFail($id);
        return view('tu_kepegawaian.tu.edit', compact('user'));
    }

    public function tuUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'nomor_induk' => 'required|string|unique:users,nomor_induk,' . $id,
            'email' => 'nullable|email|unique:users,email,' . $id,
            'role' => 'required|in:tu,tu_kepegawaian',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            
            $userData = [
                'name' => $request->name,
                'nomor_induk' => $request->nomor_induk,
                'email' => $request->email,
                'role' => $request->role,
            ];
            
            if ($request->filled('password')) {
                $userData['password'] = bcrypt($request->password);
            }
            
            $user->update($userData);

            if (Schema::hasTable('pegawais')) {
                $pegawai = Pegawai::where('user_id', $user->id)->first();
                if ($pegawai) {
                    $pegawai->update([
                        'nama' => $request->name,
                        'nip' => $request->nomor_induk,
                        'nik' => $request->nik,
                        'nuptk' => $request->nuptk,
                        'jenis_kelamin' => $request->jenis_kelamin,
                        'tempat_lahir' => $request->tempat_lahir,
                        'tanggal_lahir' => $request->tanggal_lahir,
                        'status_kepegawaian' => $request->status_kepegawaian,
                        'pendidikan' => $request->pendidikan,
                        'email' => $request->email,
                        'no_hp' => $request->no_hp,
                        'jabatan' => $request->role,
                        'alamat' => $request->alamat,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('tu_kepegawaian.tu.index')->with('success', 'Data Pegawai berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal mengupdate: ' . $e->getMessage());
        }
    }

    public function tuDestroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            $totalAdmin = User::where('role', 'tu_kepegawaian')->count();
            if ($user->role === 'tu_kepegawaian' && $totalAdmin <= 1) {
                return back()->with('error', 'GAGAL DIHAPUS! Anda adalah satu-satunya Admin. Tidak bisa menghapus akun login sendiri.');
            }

            if (Schema::hasTable('pegawais')) {
                $pegawai = Pegawai::where('user_id', $user->id)->first();
                if ($pegawai) {
                    $pegawai->forceDelete();
                }
            }

            $user->forceDelete();

            DB::commit();
            return back()->with('success', 'Data Pegawai berhasil dihapus permanen dari database.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    // ==========================================================
    // TEMPLATE DAN IMPORT TU
    // ==========================================================

    public function tuTemplate()
    {
        $export = new class implements FromCollection, WithHeadings, WithEvents {
            public function collection()
            {
                return collect([]);
            }

            public function headings(): array
            {
                return [
                    'nama',
                    'nik',
                    'nuptk',
                    'nip',
                    'jenis_ptk',
                    'tugas_tambahan',
                    'tempat_lahir',
                    'tanggal_lahir',
                    'jenis_kelamin',
                    'agama',
                    'status_kepegawaian',
                    'alamat',
                    'rt',
                    'rw',
                    'dusun',
                    'desa',
                    'kecamatan',
                    'kode_pos',
                    'no_hp',
                    'email'
                ];
            }

            public function registerEvents(): array
            {
                return [
                    AfterSheet::class => function(AfterSheet $event) {
                        $sheet = $event->sheet->getDelegate();

                        $sheet->getStyle('A1:T1')->applyFromArray([
                            'font' => [
                                'bold' => true,
                                'size' => 11,
                                'color' => ['argb' => 'FFFFFF'],
                            ],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['argb' => '28A745'],
                            ],
                            'alignment' => [
                                'horizontal' => Alignment::HORIZONTAL_CENTER,
                                'vertical' => Alignment::VERTICAL_CENTER,
                            ],
                        ]);

                        $sheet->getRowDimension(1)->setRowHeight(28);

                        $columnWidths = [
                            'A' => 25, 'B' => 20, 'C' => 20, 'D' => 20, 'E' => 22,
                            'F' => 22, 'G' => 20, 'H' => 18, 'I' => 15, 'J' => 15,
                            'K' => 25, 'L' => 30, 'M' => 10, 'N' => 10, 'O' => 20,
                            'P' => 20, 'Q' => 20, 'R' => 15, 'S' => 18, 'T' => 25
                        ];

                        foreach ($columnWidths as $col => $width) {
                            $sheet->getColumnDimension($col)->setWidth($width);
                        }
                    },
                ];
            }
        };

        return Excel::download($export, 'template_data_pegawai.xlsx');
    }

    public function tuImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ], [
            'file.required' => 'Silakan pilih file excel terlebih dahulu.',
            'file.mimes'    => 'Format file harus .xlsx, .xls, atau .csv',
            'file.max'      => 'Ukuran file maksimal 2MB'
        ]);

        try {
            $file = $request->file('file');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $successCount = 0;
            $errors = [];

            foreach ($rows as $index => $row) {
                if ($index === 0) continue;

                $nama = trim($row[0] ?? '');
                if (empty($nama)) continue;

                $nik = trim($row[1] ?? null);
                $nuptk = trim($row[2] ?? null);
                $nip = trim($row[3] ?? null);
                if (empty($nip)) {
                if (!empty($nik)) {
                    $nip = $nik;
                } elseif (!empty($email)) {
                    $nip = $email;
                } else {
                    $nip = 'IMP-' . time() . '-' . $index;
                }
            }

                $tempat_lahir = trim($row[6] ?? null);
                $jenis_kelamin = trim($row[8] ?? null);

                $rawTanggal = trim($row[7] ?? null);
                $tanggal_lahir = null;

                if (!empty($rawTanggal) && !in_array(strtoupper($rawTanggal), ['L', 'P'])) {
                    try {
                        $date = \DateTime::createFromFormat('d-m-Y', $rawTanggal);
                        if ($date) {
                            $tanggal_lahir = $date->format('Y-m-d');
                        } else {
                            $tanggal_lahir = date('Y-m-d', strtotime($rawTanggal));
                        }
                    } catch (\Exception $e) {
                        $tanggal_lahir = null;
                    }
                }

                $status_kepegawaian = trim($row[10] ?? null);
                $alamat = trim($row[11] ?? null);
                $rt = trim($row[12] ?? null);
                $rw = trim($row[13] ?? null);
                $dusun = trim($row[14] ?? null);
                $desa = trim($row[15] ?? null);
                $kecamatan = trim($row[16] ?? null);
                $kode_pos = trim($row[17] ?? null);
                $no_hp = trim($row[18] ?? null);
                $email = trim($row[19] ?? null);

                $jabatan = 'tu';
                $password = '12345678';

                if (empty($email)) {
                    $email = strtolower(str_replace(' ', '', $nama)) . time() . "@smkn1x.sch.id";
                }

                // ============================================================
                // FIX: Cegah duplikat email di tabel users
                // Kalau email sudah dipakai user lain, tambahkan suffix unik
                // ============================================================
                $emailExists = User::where('email', $email)->exists();
                if ($emailExists) {
                    $existingByEmail = User::where('email', $email)->first();

                    if ($existingByEmail && $existingByEmail->nomor_induk === $nip) {
                        $user = $existingByEmail;
                        $user->update([
                            'name' => $nama,
                            'role' => $jabatan,
                        ]);
                    } else {
                        $baseEmail = explode('@', $email)[0];
                        $domain    = explode('@', $email)[1] ?? 'smkn1x.sch.id';
                        $counter   = 1;
                        $newEmail  = $email;

                        while (User::where('email', $newEmail)->exists()) {
                            $newEmail = $baseEmail . $counter . '@' . $domain;
                            $counter++;
                        }

                        $email = $newEmail;

                        $user = User::firstOrCreate(
                            ['nomor_induk' => $nip],
                            [
                                'name'     => $nama,
                                'email'    => $email,
                                'password' => Hash::make($password),
                                'role'     => $jabatan,
                            ]
                        );
                    }
                } else {
                    $user = User::firstOrCreate(
                        ['nomor_induk' => $nip],
                        [
                            'name'     => $nama,
                            'email'    => $email,
                            'password' => Hash::make($password),
                            'role'     => $jabatan,
                        ]
                    );
                }

                if (Schema::hasTable('pegawais')) {
                    Pegawai::updateOrCreate(
                        ['nip' => $nip],
                        [
                            'nama'                  => $nama,
                            'nik'                   => $nik,
                            'nuptk'                 => $nuptk,
                            'jenis_kelamin'         => $jenis_kelamin,
                            'tempat_lahir'          => $tempat_lahir,
                            'tanggal_lahir'         => $tanggal_lahir,
                            'status_kepegawaian'    => $status_kepegawaian,
                            'email'                 => $email,
                            'no_hp'                 => $no_hp,
                            'jabatan'               => $jabatan,
                            'alamat'                => $alamat,
                            'user_id'               => $user->id,
                        ]
                    );
                }

                $successCount++;
            }

            if ($successCount === 0) {
                $errorMsg = 'Tidak ada data yang diproses. ';
                if (count($errors) > 0) {
                    $errorMsg .= 'Peringatan: ' . implode(', ', $errors);
                }
                return redirect()->back()->with('error', $errorMsg);
            }

            $msg = "Berhasil mengupdate/mengimport {$successCount} data pegawai!";
            if (count($errors) > 0) {
                $msg .= " Namun, ada " . count($errors) . " data yang gagal.";
            }

            return redirect()->back()->with('success', $msg);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    // ==========================================================
    // DOKUMEN
    // ==========================================================
    public function dokumen()
    {
        if (!Schema::hasTable('dokumens')) {
            return redirect()->route('tu_kepegawaian.dashboard')
                ->with('error', 'Tabel dokumen belum tersedia.');
        }

        $dokumens = Dokumen::all();
        return view('tu_kepegawaian.dokumen.index', compact('dokumens'));
    }

    public function dokumenIndex()
    {
        return $this->dokumen();
    }

    public function dokumenStore(Request $request)
    {
        $request->validate([
            'guru_id'      => 'required',
            'nama_dokumen' => 'required',
            'file'         => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $path = $request->file('file')->store('dokumen_pegawai', 'public');

        Dokumen::create([
            'guru_id'      => $request->guru_id,
            'nama_dokumen' => $request->nama_dokumen,
            'file_path'    => $path,
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diupload!');
    }

    // ==========================================================
    // RIWAYAT TUGAS (Model: RiwayatTugas)
    // ==========================================================
    public function riwayat()
    {
        if ($this->riwayatTugasTableAvailable()) {
            $riwayat = RiwayatTugas::all();
        } elseif ($this->riwayatTableAvailable()) {
            $riwayat = RiwayatKerja::all();
        } else {
            $riwayat = collect();
        }

        $pegawais = Schema::hasTable('pegawais') ? Pegawai::all() : collect();

        return view('tu_kepegawaian.riwayat_tugas.index', compact('riwayat', 'pegawais'));
    }

    public function riwayatIndex()
    {
        return $this->riwayat();
    }

    public function riwayatStore(Request $request)
    {
        $request->validate([
            'instansi' => 'required',
            'jabatan' => 'required',
            'mulai' => 'required|date',
        ]);

        if ($this->riwayatTugasTableAvailable()) {
            RiwayatTugas::create($request->all());
        } elseif ($this->riwayatTableAvailable()) {
            RiwayatKerja::create($request->all());
        }

        return redirect()->route('tu_kepegawaian.riwayat.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function riwayatUpdate(Request $request, $id)
    {
        $request->validate([
            'instansi' => 'required',
            'jabatan' => 'required',
            'mulai' => 'required|date',
        ]);

        if ($this->riwayatTugasTableAvailable()) {
            $riwayat = RiwayatTugas::findOrFail($id);
        } elseif ($this->riwayatTableAvailable()) {
            $riwayat = RiwayatKerja::findOrFail($id);
        } else {
            return back()->with('error', 'Tabel riwayat tidak tersedia.');
        }

        $riwayat->update($request->all());

        return redirect()->route('tu_kepegawaian.riwayat.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function riwayatDestroy($id)
    {
        if ($this->riwayatTugasTableAvailable()) {
            RiwayatTugas::findOrFail($id)->delete();
        } elseif ($this->riwayatTableAvailable()) {
            RiwayatKerja::findOrFail($id)->delete();
        }

        return redirect()->route('tu_kepegawaian.riwayat.index')->with('success', 'Data berhasil dihapus!');
    }

    // ==========================================================
    // MUTASI (Model: Mutasi)
    // ==========================================================
    public function mutasiIndex()
    {
        if ($this->mutasiTableAvailable()) {
            $mutasis = Mutasi::all();
        } elseif ($this->mutasiPegawaiTableAvailable()) {
            $mutasis = MutasiPegawai::with('pegawai')->get();
        } else {
            $mutasis = collect();
        }

        return view('tu_kepegawaian.mutasi.index', compact('mutasis'));
    }

    public function mutasiCreate()
    {
        $gurus = Guru::all();
        $pegawais = Schema::hasTable('pegawais') ? Pegawai::all() : collect();
        return view('tu_kepegawaian.mutasi.create', compact('gurus', 'pegawais'));
    }

    public function mutasiStore(Request $request)
    {
        $request->validate([
            'entitas_id'   => 'required',
            'jenis_mutasi' => 'required',
            'tanggal'      => 'required',
        ]);

        $split = explode('-', $request->entitas_id);
        $tipe  = $split[0];
        $id    = $split[1] ?? null;

        if (empty($id)) {
            return back()->with('error', 'Data yang dipilih tidak valid. Silakan pilih Guru atau Pegawai.');
        }

        $namaEntitas = '';
        if ($tipe === 'guru') {
            $guru = Guru::find($id);
            if ($guru) {
                $namaEntitas = $guru->nama;
            } else {
                return back()->with('error', 'Guru tidak ditemukan.');
            }
        } elseif ($tipe === 'pegawai' && Schema::hasTable('pegawais')) {
            $pegawai = Pegawai::find($id);
            if ($pegawai) {
                $namaEntitas = $pegawai->nama;
            } else {
                return back()->with('error', 'Pegawai tidak ditemukan.');
            }
        }

        if ($this->mutasiTableAvailable()) {
            Mutasi::create([
                'guru_id'      => $id,
                'nama_entitas' => $namaEntitas,
                'jenis'        => $request->jenis_mutasi,
                'tanggal'      => $request->tanggal,
            ]);
        } elseif ($this->mutasiPegawaiTableAvailable()) {
            MutasiPegawai::create([
                'pegawai_id' => $id,
                'jenis'      => $request->jenis_mutasi,
                'tanggal'    => $request->tanggal,
            ]);
        }

        return redirect()->route('tu_kepegawaian.mutasi.index')
                         ->with('success', 'Data mutasi berhasil ditambahkan!');
    }

    public function mutasiEdit($id)
    {
        if ($this->mutasiTableAvailable()) {
            $mutasi = Mutasi::findOrFail($id);
        } else {
            $mutasi = MutasiPegawai::findOrFail($id);
        }

        $gurus = Guru::all();
        $pegawais = Schema::hasTable('pegawais') ? Pegawai::all() : collect();

        return view('tu_kepegawaian.mutasi.edit', compact('mutasi', 'gurus', 'pegawais'));
    }

    public function mutasiUpdate(Request $request, $id)
    {
        $request->validate([
            'jenis_mutasi' => 'required',
            'tanggal'      => 'required|date',
        ]);

        if ($this->mutasiTableAvailable()) {
            $mutasi = Mutasi::findOrFail($id);
        } else {
            $mutasi = MutasiPegawai::findOrFail($id);
        }

        $mutasi->update([
            'jenis' => $request->jenis_mutasi,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('tu_kepegawaian.mutasi.index')->with('success', 'Data mutasi berhasil diperbarui.');
    }

    public function mutasiDestroy($id)
    {
        if ($this->mutasiTableAvailable()) {
            Mutasi::findOrFail($id)->delete();
        } elseif ($this->mutasiPegawaiTableAvailable()) {
            MutasiPegawai::findOrFail($id)->delete();
        }

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function mutasiLaporan()
    {
        if ($this->mutasiTableAvailable()) {
            $mutasis = Mutasi::all();
        } elseif ($this->mutasiPegawaiTableAvailable()) {
            $mutasis = MutasiPegawai::with('pegawai')->get();
        } else {
            $mutasis = collect();
        }

        return view('tu_kepegawaian.mutasi.laporan', compact('mutasis'));
    }
}