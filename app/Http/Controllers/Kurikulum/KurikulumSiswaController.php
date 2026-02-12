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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Carbon\Carbon;

class KurikulumSiswaController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $tingkat = $request->get('tingkat', '');
        $search = $request->get('search', '');
        $filterRombel = $request->get('rombel', '');
        // per-page selector (limit to safe values)
        $allowedPerPage = [10, 25, 50, 100];
        $perPage = (int) $request->get('per_page', 50);
        if (! in_array($perPage, $allowedPerPage)) {
            $perPage = 50;
        }

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

        // Ensure we select distinct data_siswa rows (prevents duplicates if joins are present)
        if (config('app.debug')) {
            DB::enableQueryLog();
        }

        $siswas = $query->select('data_siswa.*')->distinct()->latest()->paginate(15)->withQueryString();

        if (config('app.debug')) {
            Log::info('KurikulumSiswaController::index queries', DB::getQueryLog());
            try {
                $ids = $siswas->pluck('id')->toArray();
                Log::info('KurikulumSiswaController::index result_ids', $ids);
            } catch (\Throwable $e) {
                Log::info('KurikulumSiswaController::index result_ids error', ['err' => $e->getMessage()]);
            }
        }

        return view('kurikulum.siswa.index', compact('siswas', 'tingkat', 'search', 'filterRombel', 'allRombels', 'perPage'));
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
        return view('kurikulum.siswa.edit', compact('siswa'));
    }

    public function editDataDiri($id)
    {
        $siswa = DataSiswa::with(['ayah', 'ibu', 'wali'])->findOrFail($id);
        $rombels = Rombel::all();
        $kelas = Kelas::with('jurusan')->get();

        return view('kurikulum.siswa.data-diri.edit', compact('siswa','rombels','kelas'));
    }

    public function update(Request $request, $id)
    {
        $siswa = DataSiswa::findOrFail($id);

        // Check if this is a password update (only password fields provided)
        if ($request->filled('password') || $request->filled('password_confirmation')) {
            $request->validate([
                'password' => 'nullable|string|min:6|confirmed',
            ]);

            if ($request->filled('password')) {
                $user = $siswa->user;
                if ($user) {
                    $user->update(['password' => Hash::make($request->password)]);
                    return redirect()->route('kurikulum.siswa.index')->with('success', 'Password siswa berhasil diubah.');
                }
            }
            return back()->with('error', 'User tidak ditemukan');
        }

        // Otherwise, this is a data-diri update
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'nullable|string',
            'nisn' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string',
            'agama' => 'nullable|string',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'kelas' => 'nullable|string',
            'tanggal_diterima' => 'nullable|date',
            'rombel_id' => 'nullable|exists:rombels,id',
            'email' => 'nullable|email',
            // Parent data
            'ayah_nama' => 'nullable|string|max:255',
            'ayah_pekerjaan' => 'nullable|string|max:255',
            'ayah_telepon' => 'nullable|string|max:50',
            'ayah_alamat' => 'nullable|string|max:1000',
            'ibu_nama' => 'nullable|string|max:255',
            'ibu_pekerjaan' => 'nullable|string|max:255',
            'ibu_telepon' => 'nullable|string|max:50',
            'ibu_alamat' => 'nullable|string|max:1000',
            'wali_nama' => 'nullable|string|max:255',
            'wali_pekerjaan' => 'nullable|string|max:255',
            'wali_telepon' => 'nullable|string|max:50',
            'wali_alamat' => 'nullable|string|max:1000',
        ]);

        // Update siswa data
        $siswa->update([
            'nama_lengkap' => $data['nama_lengkap'],
            'nis' => $data['nis'],
            'nisn' => $data['nisn'],
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'agama' => $data['agama'],
            'alamat' => $data['alamat'],
            'no_hp' => $data['no_hp'],
            'kelas' => $data['kelas'],
            'tanggal_diterima' => $data['tanggal_diterima'],
            'rombel_id' => $data['rombel_id'],
        ]);

        // Update or create Ayah
        $siswa->ayah()->updateOrCreate(['siswa_id' => $siswa->id], [
            'nama' => $data['ayah_nama'],
            'pekerjaan' => $data['ayah_pekerjaan'],
            'telepon' => $data['ayah_telepon'],
            'alamat' => $data['ayah_alamat'],
        ]);

        // Update or create Ibu
        $siswa->ibu()->updateOrCreate(['siswa_id' => $siswa->id], [
            'nama' => $data['ibu_nama'],
            'pekerjaan' => $data['ibu_pekerjaan'],
            'telepon' => $data['ibu_telepon'],
            'alamat' => $data['ibu_alamat'],
        ]);

        // Update or create Wali
        $siswa->wali()->updateOrCreate(['siswa_id' => $siswa->id], [
            'nama' => $data['wali_nama'],
            'pekerjaan' => $data['wali_pekerjaan'],
            'telepon' => $data['wali_telepon'],
            'alamat' => $data['wali_alamat'],
        ]);

        return redirect()->route('kurikulum.data-siswa.show', $siswa->id)->with('success', 'Data siswa berhasil diperbarui.');
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
     * Import siswa from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            $path = $request->file('file');
            $sheets = Excel::toArray(new class {}, $path);
            
            if (empty($sheets) || !is_array($sheets)) {
                return back()->with('error', 'File kosong atau format tidak dikenali.');
            }

            // Get first sheet with data
            $rows = null;
            foreach ($sheets as $sheet) {
                if (is_array($sheet) && count($sheet) > 1) {
                    $rows = $sheet;
                    break;
                }
            }

            if (!is_array($rows) || count($rows) < 2) {
                return back()->with('error', 'Tidak ada data pada file.');
            }

            $created = 0;
            $updated = 0;

            // Process rows starting from row 1 (skip header)
            for ($r = 1; $r < count($rows); $r++) {
                $row = $rows[$r];
                
                // Skip empty rows
                $allEmpty = true;
                foreach ($row as $cell) {
                    if (trim((string)$cell) !== '') {
                        $allEmpty = false;
                        break;
                    }
                }
                if ($allEmpty) continue;

                // Extract data (basic mapping)
                $nama = trim((string)($row[0] ?? ''));
                $nis = trim((string)($row[1] ?? ''));
                $nisn = trim((string)($row[2] ?? ''));

                if (empty($nama)) continue;

                // Find or create siswa
                $siswa = DataSiswa::where('nis', $nis)->first();
                if ($siswa) {
                    $siswa->update([
                        'nama_lengkap' => $nama,
                        'nisn' => $nisn ?: $siswa->nisn,
                    ]);
                    $updated++;
                } else {
                    DataSiswa::create([
                        'nama_lengkap' => $nama,
                        'nis' => $nis,
                        'nisn' => $nisn,
                        'jenis_kelamin' => 'Laki-laki',
                    ]);
                    $created++;
                }
            }

            return redirect()->route('kurikulum.siswa.index')
                ->with('success', "Import selesai. Dibuat: {$created}. Diperbarui: {$updated}.");

        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal mengimport file: ' . $e->getMessage());
        }
    }

    /**
     * Cetak data siswa (PDF)
     */
    public function cetak($id)
    {
        $siswa = DataSiswa::with(['ayah', 'ibu', 'wali', 'rombel'])->findOrFail($id);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('kurikulum.siswa.data-diri.pdf', compact('siswa'))
            ->setPaper('A4', 'portrait');
        
        $filename = 'Data Diri - ' . ($siswa->nama_lengkap ?? $siswa->nis ?? $siswa->id) . '.pdf';
        
        return $pdf->stream($filename);
    }
}