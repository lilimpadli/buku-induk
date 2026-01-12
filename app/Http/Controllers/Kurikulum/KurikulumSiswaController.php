<?php


namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\User;
use App\Models\Rombel;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class KurikulumSiswaController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $tingkat = $request->get('tingkat', '');
        $search = $request->get('search', '');
        $filterRombel = $request->get('rombel', '');

        // Query dasar dengan relasi
        $query = DataSiswa::with(['user', 'ayah', 'ibu', 'wali', 'rombel.kelas.jurusan']);

        // Filter by tingkat (kelas level)
        if (!empty($tingkat)) {
            $query->whereHas('rombel.kelas', function ($q) use ($tingkat) {
                $q->where('tingkat', $tingkat);
            });
        }

        // Filter by rombel
        if (!empty($filterRombel)) {
            $query->where('rombel_id', $filterRombel);
        }

        // Filter by search (nama, NIS, NISN)
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        // Get all rombels for dropdown
        $allRombels = Rombel::with('kelas.jurusan')->get();

        // Get results with pagination
        $siswas = $query->latest()->paginate(15)->withQueryString();

        return view('kurikulum.siswa.index', compact('siswas', 'tingkat', 'search', 'filterRombel', 'allRombels'));
    }

    public function create()
    {
        $users = User::where('role', 'siswa')->get();
        $rombels = Rombel::all();
        $kelas = Kelas::with('jurusan')->get();
        $jurusans = Jurusan::all();

        return view('kurikulum.siswa.create', compact('users','rombels','kelas','jurusans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'nullable|string',
            'nisn' => 'nullable|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'nullable|string',
            'agama' => 'nullable|string',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'kelas' => 'nullable|string',
            'tanggal_diterima' => 'nullable|date',
            'rombel_id' => 'nullable|exists:rombels,id',
            'email' => 'nullable|email',
        ]);

        // If no existing user selected, either associate an existing user by NIS/email
        // or create a new user for this siswa
        if (empty($data['user_id'])) {
            $submittedNis = $request->input('nis');
            $submittedEmail = $request->input('email');

            $existingUser = null;
            if ($submittedNis || $submittedEmail) {
                $existingUser = User::where(function ($q) use ($submittedNis, $submittedEmail) {
                    if ($submittedNis) {
                        $q->orWhere('nomor_induk', $submittedNis);
                    }
                    if ($submittedEmail) {
                        $q->orWhere('email', $submittedEmail);
                    }
                })->first();
            }

            if ($existingUser) {
                // if a user exists, associate it (ensure it's a siswa role)
                if ($existingUser->role !== 'siswa') {
                    return back()->withInput()->withErrors(['nis' => 'A user with this NIS/email exists but is not a siswa.']);
                }

                $user = $existingUser;
                $data['user_id'] = $user->id;
            } else {
                $createUserRules = [
                    'password' => 'required|string|min:8|confirmed',
                    'nis' => 'nullable|unique:users,nomor_induk',
                    'email' => 'nullable|email|unique:users,email',
                ];

                $request->validate($createUserRules);

                try {
                    $user = User::create([
                        'name' => $data['nama_lengkap'],
                        'nomor_induk' => $submittedNis ?? null,
                        'email' => $submittedEmail ?? null,
                        'password' => Hash::make($request->input('password')),
                        'role' => 'siswa',
                    ]);
                } catch (QueryException $e) {
                    // handle unique constraint at DB level (race conditions etc.)
                    if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062) {
                        return back()->withInput()->withErrors(['nis' => 'Nomor induk atau email sudah terdaftar.']);
                    }

                    throw $e;
                }

                $data['user_id'] = $user->id;
            }
        } else {
            $user = User::find($data['user_id']);
        }

        // prefer nis from request; if empty, derive from user->nomor_induk
        $data['nis'] = $request->input('nis') ?? $user->nomor_induk ?? null;

        // Ensure potentially required DB columns exist in payload (avoid SQL errors when column has no default)
        $data['tanggal_lahir'] = $data['tanggal_lahir'] ?? null;
        $data['tanggal_diterima'] = $data['tanggal_diterima'] ?? null;
        $data['agama'] = $data['agama'] ?? null;
        $data['alamat'] = $data['alamat'] ?? null;
        $data['no_hp'] = $data['no_hp'] ?? null;

        DataSiswa::create($data);

        return redirect()->route('kurikulum.siswa.index')->with('success', 'Data siswa ditambahkan.');
    }

    public function edit($id)
    {
        $siswa = DataSiswa::findOrFail($id);
        $users = User::where('role', 'siswa')->get();
        $rombels = Rombel::all();
        $kelas = Kelas::with('jurusan')->get();
        $jurusans = Jurusan::all();

        return view('kurikulum.siswa.edit', compact('siswa','users','rombels','kelas','jurusans'));
    }

    public function update(Request $request, $id)
    {
        $siswa = DataSiswa::findOrFail($id);
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'nullable|string',
            'nisn' => 'nullable|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'nullable|string',
            'agama' => 'nullable|string',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'kelas' => 'nullable|string',
            'tanggal_diterima' => 'nullable|date',
            'rombel_id' => 'nullable|exists:rombels,id',
            'email' => 'nullable|email',
        ]);

        if (empty($data['user_id'])) {
            // keep existing associated user
            $data['user_id'] = $siswa->user_id;
            $user = User::find($data['user_id']);
        } else {
            $user = User::find($data['user_id']);
        }

        $data['nis'] = $request->input('nis') ?? $user->nomor_induk ?? $siswa->nis;

        $siswa->update($data);

        return redirect()->route('kurikulum.siswa.index')->with('success', 'Data siswa diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = DataSiswa::findOrFail($id);
        $siswa->delete();
        return redirect()->route('kurikulum.siswa.index')->with('success', 'Data siswa dihapus.');
    }

    public function show($id)
    {
        $siswa = DataSiswa::with('user','rombel','ayah','ibu','wali')->findOrFail($id);
        return view('kurikulum.siswa.data-diri.show', compact('siswa'));
    }

    /**
     * Show import form for siswa
     */
    public function importForm()
    {
        return view('kurikulum.siswa.import');
    }

    /**
     * Import siswa from Excel and create associated User accounts with default password 12345678
     */
   public function import(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls,csv'
    ]);

    $path = $request->file('file');

    $sheets = Excel::toArray([], $path);
    if (empty($sheets) || !isset($sheets[0])) {
        return back()->with('error', 'File kosong atau format tidak dikenali.');
    }

    $rows = $sheets[0];
    if (count($rows) < 2) {
        return back()->with('error', 'Tidak ada data pada file. Pastikan baris header ada.');
    }

    $header = array_map(function ($h) {
        return (string)Str::of($h)->lower()->trim();
    }, $rows[0]);

    $map = [];
    foreach ($header as $i => $h) {
        $lower = $h;

        // Kita hanya butuh memetakan kolom-kolom penting saja
        if (str_contains($lower, 'nomor') || str_contains($lower, 'nomor_induk') || str_contains($lower, 'nomor induk')) {
            $map['nomor_induk'] = $i;
        }

        if (str_contains($lower, 'nisn')) {
            $map['nisn'] = $i;
        }

        // KITA TIDAK PERLU MEMETAKAN 'nis' LAGI KARENA AKAN MENGGUNAKAN 'nomor_induk'

        if (str_contains($lower, 'rombel_id') || str_contains($lower, 'id_rombel') || str_contains($lower, 'id rombel')) {
            $map['rombel_id'] = $i;
        }

        if (str_contains($lower, 'nama_rombel') || str_contains($lower, 'rombel')) {
            $map['nama_rombel'] = $i;
        }

        if (str_contains($lower, 'nama') && !str_contains($lower, 'rombel')) {
            $map['nama_lengkap'] = $i;
        }

        if (str_contains($lower, 'jenis') && str_contains($lower, 'kelamin')) {
            $map['jenis_kelamin'] = $i;
        }

        if (str_contains($lower, 'email')) {
            $map['email'] = $i;
        }
    }

    // Debug: Lihat pemetaan kolom yang berhasil
    \Log::info('Pemetaan Kolom: ' . json_encode($map));

    $created = 0;
    $skipped = 0;
    $errors = [];

    for ($r = 1; $r < count($rows); $r++) {
        $row = $rows[$r];
        $allEmpty = true;
        foreach ($row as $cell) {
            if (trim((string)$cell) !== '') { $allEmpty = false; break; }
        }
        if ($allEmpty) continue;

        // --- PERUBAHAN UTAMA DIMULAI DI SINI ---

        // 1. Ambil nilai nomor_induk dari Excel. Ini akan kita gunakan untuk NIS juga.
        $nomorInduk = isset($map['nomor_induk']) ? trim((string)($row[$map['nomor_induk']] ?? '')) : null;

        // 2. Ambil nilai-nilai lainnya
        $nama = isset($map['nama_lengkap']) ? trim((string)($row[$map['nama_lengkap']] ?? '')) : null;
        $jenis = isset($map['jenis_kelamin']) ? trim((string)($row[$map['jenis_kelamin']] ?? '')) : null;
        
        // Normalisasi jenis kelamin
        if ($jenis !== null) {
            $jnorm = strtolower($jenis);
            $jnorm = str_replace([' ', '\t', '\n', "-"], '', $jnorm);
            if (in_array($jnorm, ['l','lk','laki','lakilaki','laki-laki','lk-lk'])) {
                $jenis = 'L';
            } elseif (in_array($jnorm, ['p','pr','per','perempuan','perempuant'])) {
                $jenis = 'P';
            } elseif ($jnorm === '') {
                $jenis = '';
            } else {
                $errors[] = "Baris " . ($r+1) . ": nilai jenis_kelamin tidak dikenali ('{$jenis}').";
            }
        }
        
        $nisn = isset($map['nisn']) ? trim((string)($row[$map['nisn']] ?? '')) : null;
        $email = isset($map['email']) ? trim((string)($row[$map['email']] ?? '')) : null;
        $namaRombel = isset($map['nama_rombel']) ? trim((string)($row[$map['nama_rombel']] ?? '')) : null;
        $rombelIdFromSheet = isset($map['rombel_id']) ? trim((string)($row[$map['rombel_id']] ?? '')) : null;

        // Debug: Lihat nilai yang diambil dari baris pertama untuk memastikan
        if ($r == 1) {
            \Log::info("Contoh Baris 1: Nomor Induk={$nomorInduk}, Nama={$nama}, Jenis={$jenis}");
        }

        if (empty($nama)) {
            $errors[] = "Baris " . ($r+1) . ": nama kosong, dilewati.";
            $skipped++;
            continue;
        }

        // Cari user yang sudah ada berdasarkan nomor_induk atau email
        $existingUser = null;
        if ($nomorInduk) {
            $existingUser = User::where('nomor_induk', $nomorInduk)->first();
        }
        if (!$existingUser && $email) {
            $existingUser = User::where('email', $email)->first();
        }

        try {
            if ($existingUser) {
                if ($existingUser->role !== 'siswa') {
                    $errors[] = "Baris " . ($r+1) . ": user ada tapi bukan role siswa (nomor_induk={$nomorInduk}).";
                    $skipped++;
                    continue;
                }
                $user = $existingUser;
            } else {
                // Buat email default jika kosong
                if (empty($email)) {
                    $email = $nomorInduk ? "{$nomorInduk}@example.local" : strtolower(str_replace(' ', '.', strtok($nama, ' '))) . '@example.local';
                }

                $user = User::create([
                    'name' => $nama,
                    'nomor_induk' => $nomorInduk ?: null,
                    'email' => $email,
                    'password' => Hash::make('12345678'),
                    'role' => 'siswa',
                ]);
            }
        } catch (\Throwable $e) {
            $errors[] = "Baris " . ($r+1) . ": gagal membuat/mengambil user ({$e->getMessage()}).";
            $skipped++;
            continue;
        }

        $rombelId = null;

        // Cari rombel berdasarkan id atau nama
        if (!empty($rombelIdFromSheet)) {
            if (is_numeric($rombelIdFromSheet)) {
                $rombelModel = Rombel::find((int)$rombelIdFromSheet);
                if ($rombelModel) {
                    $rombelId = $rombelModel->id;
                } else {
                    $errors[] = "Baris " . ($r+1) . ": rombel_id '{$rombelIdFromSheet}' tidak ditemukan.";
                }
            } else {
                $errors[] = "Baris " . ($r+1) . ": nilai rombel_id tidak numerik ('{$rombelIdFromSheet}'), mencoba pencocokan nama.";
            }
        }

        if (empty($rombelId) && !empty($namaRombel)) {
            $normalize = function ($s) {
                $s = strtolower(trim((string)$s));
                $s = preg_replace('/\s+/u', ' ', $s);
                $s = str_replace([".", ","], '', $s);
                return $s;
            };

            $needle = $normalize($namaRombel);
            $rombel = Rombel::all()->first(function ($r) use ($needle, $normalize) {
                $hay = $normalize($r->nama);
                return ($needle !== '' && (strpos($hay, $needle) !== false || strpos($needle, $hay) !== false));
            });

            if ($rombel) $rombelId = $rombel->id;
        }

        try {
            // --- PERUBAHAN KRUSIAL DI SINI ---
            // Gunakan $nomorInduk untuk field 'nis'. Ini menjamin nilainya selalu sama.
            DataSiswa::create([
                'user_id' => $user->id,
                'nama_lengkap' => $nama,
                'nis' => $nomorInduk, // <--- INI YANG DIUBAH
                'nisn' => $nisn,
                'jenis_kelamin' => $jenis,
                'rombel_id' => $rombelId,
            ]);

            $created++;
        } catch (\Throwable $e) {
            $errors[] = "Baris " . ($r+1) . ": gagal menyimpan siswa ({$e->getMessage()}).";
            $skipped++;
            continue;
        }
    }

    $msg = "Import selesai. Dibuat: {$created}. Dilewati: {$skipped}.";
    if (!empty($errors)) {
        $msg .= ' Beberapa peringatan: ' . implode(' | ', array_slice($errors,0,10));
    }

    return redirect()->route('kurikulum.siswa.index')->with('success', $msg);
}
}