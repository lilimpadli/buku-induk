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
use App\Imports\GuruImport;
use App\Exports\GuruTemplateExport;
use App\Models\Dokumen;
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
    private function riwayatTableAvailable(): bool
    {
        return Schema::hasTable('riwayat_kerjas');
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
        'tugas_tambahan' => 'Tugas Tambahan',
        'tempat_lahir' => 'Tempat Lahir',
        'tanggal_lahir' => 'Tanggal Lahir',
        'email_pribadi' => 'Email Pribadi',
        'email_resmi' => 'Email Resmi',
        'alamat' => 'Alamat',
        'rt' => 'RT',
        'rw' => 'RW',
        'dusun' => 'Dusun',
        'kelurahan' => 'Kelurahan',
        'kecamatan' => 'Kecamatan',
        'kode_pos' => 'Kode Pos',
        'no_hp' => 'No HP',
    ];

    private static $guruColumnsCache = null;

    private function guruDataFromRequest(Request $request): array
    {
        $fields = [
            'nama', 'nik', 'nuptk', 'nip',
            'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
            'status_kepegawaian', 'status_aktif', 'pendidikan', 'serdik',
            'tugas_tambahan',
            'telepon', 'no_hp', 'email', 'email_pribadi', 'email_resmi',
            'alamat', 'alamat_jalan', 'rt', 'rw', 'dusun', 'desa', 'kelurahan',
            'kecamatan', 'kode_pos', 'jurusan_id', 'gelar_belakang',
        ];

        $data = $request->only($fields);

        if (self::$guruColumnsCache === null) {
            self::$guruColumnsCache = Schema::getColumnListing('gurus');
        }
        $guruColumns = self::$guruColumnsCache;

        $aliases = [
            'alamat_jalan' => 'alamat',
            'alamat'       => 'alamat_jalan',
            'desa'         => 'kelurahan',
            'kelurahan'    => 'desa',
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

        return array_filter($data, function ($value, $key) use ($guruColumns) {
            return in_array($key, $guruColumns);
        }, ARRAY_FILTER_USE_BOTH);
    }

    // --- DASHBOARD ---
    public function dashboard()
    {
        $totalGuru          = Guru::count();
        $totalTU            = Pegawai::where('jabatan', 'tu')->count();
        $totalTUKepegawaian = Pegawai::where('jabatan', 'tu_kepegawaian')->count();
        $totalPegawai       = Pegawai::count();
        $totalPegawaiLainnya = max(0, $totalPegawai - $totalTU - $totalTUKepegawaian);
        $totalStaffAktif    = $totalGuru + $totalPegawai;

        $guruBaru = Guru::with('user')->latest()->take(5)->get();

        $hitungStatus = function ($query, string $status) {
            return (clone $query)
                ->whereRaw("LOWER(TRIM(status_kepegawaian)) = ?", [strtolower($status)])
                ->count();
        };

        $guruQuery = Guru::query();
        $totalGuruPNS       = $hitungStatus($guruQuery, 'PNS');
        $totalGuruPPPK      = $hitungStatus($guruQuery, 'PPPK');
        $totalGuruPPPKParuh = $hitungStatus($guruQuery, 'PPPK Paruh Waktu');

        $tuQuery = Pegawai::query();
        $totalTUPNS      = $hitungStatus($tuQuery, 'PNS');
        $totalTUPPPK     = $hitungStatus($tuQuery, 'PPPK');
        $totalTUPPKParuh = $hitungStatus($tuQuery, 'PPPK Paruh Waktu');

        return view('tu_kepegawaian.dashboard', compact(
            'totalGuru', 'totalTU', 'totalTUKepegawaian', 'totalStaffAktif', 'guruBaru',
            'totalPegawai', 'totalPegawaiLainnya',
            'totalGuruPNS', 'totalGuruPPPK', 'totalGuruPPPKParuh',
            'totalTUPNS', 'totalTUPPPK', 'totalTUPPKParuh'
        ));
    }

    // --- DATA GURU ---
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
            'tugas_tambahan' => 'nullable|string|max:255',
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
            'tugas_tambahan' => 'nullable|string|max:255',
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
            'nomor_induk' => 'required|string|unique:pegawais,nip',
            'email' => 'nullable|email|unique:pegawais,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:tu,tu_kepegawaian',
            'tugas_tambahan' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'nomor_induk' => $request->nomor_induk,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

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
            'tugas_tambahan' => $request->tugas_tambahan,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'jabatan' => $request->role,
            'alamat' => $request->alamat,
            'user_id' => $user->id,
        ]);

        return redirect()->route('tu_kepegawaian.tu.index')->with('success', 'Akun dan Data Pegawai berhasil ditambahkan');
    }

    public function tuShow($id)
    {
        $pegawai = Pegawai::with('user')->findOrFail($id);
        return view('tu_kepegawaian.tu.show', compact('pegawai'));
    }

    public function tuEdit($id)
    {
        $pegawai = Pegawai::with('user')->findOrFail($id);
        return view('tu_kepegawaian.tu.edit', compact('pegawai'));
    }

    public function tuUpdate(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'nip' => 'required|unique:pegawais,nip,' . $id,
            'email' => 'nullable|email|unique:pegawais,email,' . $id,
            'jabatan' => 'required|in:tu,tu_kepegawaian',
            'password' => 'nullable|string|min:6|confirmed',
            'tugas_tambahan' => 'nullable|string|max:255',
        ]);

        if ($pegawai->user) {
            $dataUser = [
                'name' => $request->name,
                'nomor_induk' => $request->nip,
                'email' => $request->email,
                'role' => $request->jabatan,
            ];

            if ($request->filled('password')) {
                $dataUser['password'] = bcrypt($request->password);
            }

            $pegawai->user->update($dataUser);
        }

        $pegawai->update([
            'nama' => $request->name,
            'nip' => $request->nip,
            'nik' => $request->nik,
            'nuptk' => $request->nuptk,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'status_kepegawaian' => $request->status_kepegawaian,
            'pendidikan' => $request->pendidikan,
            'tugas_tambahan' => $request->tugas_tambahan,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'jabatan' => $request->jabatan,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('tu_kepegawaian.tu.index')->with('success', 'Data Pegawai berhasil diupdate');
    }

    public function tuDestroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        if ($pegawai->user) {
            $user = $pegawai->user;

            $totalAdmin = User::where('role', 'tu_kepegawaian')->count();
            if ($user->role === 'tu_kepegawaian' && $totalAdmin <= 1) {
                return back()->with('error', 'GAGAL DIHAPUS! Anda adalah satu-satunya Admin. Tidak bisa menghapus akun login sendiri.');
            }

            $user->forceDelete();
        }

        $pegawai->forceDelete();

        return back()->with('success', 'Data Pegawai berhasil dihapus permanen dari database.');
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
                    $nip = 'IMP-' . time() . '-' . $index;
                }

                // Kolom ke-5 adalah tugas_tambahan (jenis_ptk di template diabaikan)
                $tugas_tambahan = trim($row[5] ?? null);

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

                $user = User::firstOrCreate(
                    ['nomor_induk' => $nip],
                    [
                        'name'      => $nama,
                        'email'     => $email,
                        'password'  => Hash::make($password),
                        'role'      => $jabatan,
                    ]
                );

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
                        'tugas_tambahan'        => $tugas_tambahan,
                        'email'                 => $email,
                        'no_hp'                 => $no_hp,
                        'jabatan'               => $jabatan,
                        'alamat'                => $alamat,
                        'user_id'               => $user->id,
                    ]
                );

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

    // --- PENUGASAN ---
    public function dokumen()
    {
        $dokumens = Dokumen::all();
        return view('tu_kepegawaian.dokumen.index', compact('dokumens'));
    }

    // --- RIWAYAT TUGAS (BERSIH, TANPA DOBEL) ---
    public function riwayat()
    {
        $riwayat = RiwayatTugas::all();
        $pegawais = Pegawai::all();
        return view('tu_kepegawaian.riwayat_tugas.index', compact('riwayat', 'pegawais'));
    }

    public function riwayatStore(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'instansi' => 'required',
            'jabatan' => 'required',
            'mulai' => 'required|date',
        ]);

        RiwayatTugas::create($request->all());

        return redirect()->route('tu_kepegawaian.riwayat.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function riwayatUpdate(Request $request, $id)
    {
        $riwayat = RiwayatTugas::findOrFail($id);

        $request->validate([
            'instansi' => 'required',
            'jabatan' => 'required',
            'mulai' => 'required|date',
        ]);

        $riwayat->update($request->all());

        return redirect()->route('tu_kepegawaian.riwayat.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function riwayatDestroy($id)
    {
        RiwayatTugas::findOrFail($id)->delete();
        return redirect()->route('tu_kepegawaian.riwayat.index')->with('success', 'Data berhasil dihapus!');
    }

    public function riwayatIndex()
    {
        return $this->riwayat();
    }

    // --- MUTASI ---
    public function mutasiIndex()
    {
        $mutasis = Mutasi::with([])->get();
        return view('tu_kepegawaian.mutasi.index', compact('mutasis'));
    }

    public function mutasiCreate()
    {
        $gurus = Guru::all();
        $pegawais = Pegawai::all();
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
        $id    = $split[1];

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
        } elseif ($tipe === 'pegawai') {
            $pegawai = Pegawai::find($id);
            if ($pegawai) {
                $namaEntitas = $pegawai->nama;
            } else {
                return back()->with('error', 'Pegawai tidak ditemukan.');
            }
        }

        Mutasi::create([
            'guru_id'      => $id,
            'nama_entitas' => $namaEntitas,
            'jenis'        => $request->jenis_mutasi,
            'tanggal'      => $request->tanggal,
        ]);

        return redirect()->route('tu_kepegawaian.mutasi.index')
                         ->with('success', 'Data mutasi berhasil ditambahkan!');
    }

    public function mutasiEdit($id)
    {
        $mutasi = Mutasi::findOrFail($id);
        $gurus = Guru::all();
        $pegawais = Pegawai::all();

        return view('tu_kepegawaian.mutasi.edit', compact('mutasi', 'gurus', 'pegawais'));
    }

    public function mutasiUpdate(Request $request, $id)
    {
        $mutasi = Mutasi::findOrFail($id);

        $request->validate([
            'jenis_mutasi' => 'required',
            'tanggal'      => 'required|date',
        ]);

        $mutasi->update([
            'jenis' => $request->jenis_mutasi,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('tu_kepegawaian.mutasi.index')->with('success', 'Data mutasi berhasil diperbarui.');
    }

    public function mutasiDestroy($id)
    {
        Mutasi::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}