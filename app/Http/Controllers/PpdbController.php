<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ppdb;
use App\Models\Rombel;
use App\Models\DataSiswa;
use App\Models\Ayah;
use App\Models\Ibu;
use App\Models\Wali;
use App\Models\User;
use App\Models\JalurPpdb;
use App\Models\SesiPpdb;
use App\Models\Jurusan;
use App\Models\PpdbTimeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Support\Str;

class PpdbController extends Controller
{
    // =========================
    // HALAMAN PILIH SESI & JALUR (PUBLIC)
    // =========================
    public function index()
    {
        $allSesis = SesiPpdb::orderBy('tahun_ajaran', 'desc')->get();

        if (Schema::hasTable('ppdb_timelines')) {
            $opens = PpdbTimeline::pluck('open', 'stage')->toArray();
            $hasTahap1 = !empty($opens['tahap1']);
            $hasTahap2 = !empty($opens['tahap2']);

            $sesis = $allSesis->filter(function($s) use ($hasTahap1, $hasTahap2) {
                // Prefer explicit stage column on sesi; fallback to name matching
                if (!empty($s->stage)) {
                    $stage = strtolower(trim($s->stage));
                    if ($stage === 'tahap1') return $hasTahap1;
                    if ($stage === 'tahap2') return $hasTahap2;
                    return false;
                }

                $name = strtolower(trim($s->nama_sesi ?? ''));
                $isTahap1 = (strpos($name, 'tahap 1') !== false || strpos($name, 'tahap1') !== false || strpos($name, 'sesi 1') !== false || strpos($name, 'sesi1') !== false);
                $isTahap2 = (strpos($name, 'tahap 2') !== false || strpos($name, 'tahap2') !== false || strpos($name, 'sesi 2') !== false || strpos($name, 'sesi2') !== false);

                // If both tahap open, include everything (including undecided)
                if ($hasTahap1 && $hasTahap2) return true;

                // If only satu tahap terbuka, only show sessions matching that tahap
                if ($hasTahap1 && !$hasTahap2) return $isTahap1;
                if ($hasTahap2 && !$hasTahap1) return $isTahap2;

                // none open -> hide all
                return false;
            })->values();
        } else {
            $sesis = $allSesis;
        }

        $data = [
            'sesis'    => $sesis,
            'jalurs'   => JalurPpdb::orderBy('nama_jalur')->get(),
            'jurusans' => Jurusan::orderBy('nama')->get(),
        ];

        if (request()->routeIs('kurikulum.*')) {
            // enrich all sesi (not only filtered) with ppdb counts and jalur counts for kurikulum view
            $allSessions = SesiPpdb::orderBy('tahun_ajaran', 'desc')->get();
            $sesisDetailed = $allSessions->map(function($sesi) {
                $sesi->ppdb_count = Ppdb::where('sesi_ppdb_id', $sesi->id)->count();
                $sesi->jalurs = JalurPpdb::withCount(['ppdb' => function($q) use ($sesi) {
                    $q->where('sesi_ppdb_id', $sesi->id);
                }])->orderBy('nama_jalur')->get();
                return $sesi;
            });

            // counts per tahap (prefer explicit stage, fallback to name matching)
            $tahapCounts = ['tahap1' => 0, 'tahap2' => 0];
            $allSessions = SesiPpdb::all();
            foreach ($allSessions as $s) {
                $count = Ppdb::where('sesi_ppdb_id', $s->id)->count();
                if (!empty($s->stage)) {
                    $st = strtolower(trim($s->stage));
                    if ($st === 'tahap1') $tahapCounts['tahap1'] += $count;
                    if ($st === 'tahap2') $tahapCounts['tahap2'] += $count;
                    continue;
                }
                $name = strtolower(trim($s->nama_sesi ?? ''));
                if (str_contains($name, 'tahap 1') || str_contains($name, 'tahap1') || str_contains($name, 'sesi 1') || str_contains($name, 'sesi1')) {
                    $tahapCounts['tahap1'] += $count;
                } elseif (str_contains($name, 'tahap 2') || str_contains($name, 'tahap2') || str_contains($name, 'sesi 2') || str_contains($name, 'sesi2')) {
                    $tahapCounts['tahap2'] += $count;
                }
            }

            $data['sesisDetailed'] = $sesisDetailed;
            $data['tahapCounts'] = $tahapCounts;

            // group sesiDetailed by tahap for view convenience
            $tahapSessions = ['tahap1' => collect(), 'tahap2' => collect()];
            foreach ($sesisDetailed as $sesi) {
                if (!empty($sesi->stage)) {
                    $st = strtolower(trim($sesi->stage));
                    if ($st === 'tahap1') $tahapSessions['tahap1']->push($sesi);
                    elseif ($st === 'tahap2') $tahapSessions['tahap2']->push($sesi);
                    else $tahapSessions['tahap1']->push($sesi);
                    continue;
                }

                $name = strtolower(trim($sesi->nama_sesi ?? ''));
                if (str_contains($name, 'tahap 1') || str_contains($name, 'tahap1') || str_contains($name, 'sesi 1') || str_contains($name, 'sesi1')) {
                    $tahapSessions['tahap1']->push($sesi);
                } elseif (str_contains($name, 'tahap 2') || str_contains($name, 'tahap2') || str_contains($name, 'sesi 2') || str_contains($name, 'sesi2')) {
                    $tahapSessions['tahap2']->push($sesi);
                } else {
                    // default to tahap1 if undecided
                    $tahapSessions['tahap1']->push($sesi);
                }
            }

            $data['tahapSessions'] = $tahapSessions;

            return view('kurikulum.ppdb.index', $data);
        }

        return view('ppdb.index', $data);
    }

    // =========================
    // DAFTAR JURUSAN UNTUK TU
    // =========================
    public function tuIndex()
    {
        $jurusans = Jurusan::orderBy('nama')->get();

        return view('tu.ppdb.index', compact('jurusans'));
    }

    // =========================
    // SHOW JURUSAN DENGAN SESI DAN JALUR
    // =========================
    public function showJurusan($id)
    {
        $jurusan = Jurusan::findOrFail($id);

        // Ambil semua sesi dengan count pendaftar untuk jurusan ini
        $sesis = SesiPpdb::withCount(['ppdb' => function($query) use ($id) {
            $query->where('jurusan_id', $id);
        }])->orderBy('tahun_ajaran', 'desc')->get();

        // for each sesi, attach jalurs with counts filtered by jurusan + sesi
        $sesis->transform(function($sesi) use ($id) {
            $sesi->jalurs = JalurPpdb::withCount(['ppdb' => function($q) use ($id, $sesi) {
                $q->where('jurusan_id', $id)->where('sesi_ppdb_id', $sesi->id);
            }])->orderBy('nama_jalur')->get();
            return $sesi;
        });

        // Ambil semua jalur dengan count pendaftar untuk jurusan ini (overall)
        $jalurs = JalurPpdb::withCount(['ppdb' => function($query) use ($id) {
            $query->where('jurusan_id', $id);
        }])->orderBy('nama_jalur')->get();

        // group sesi into tahap1 / tahap2 for the view
        $tahapSessions = ['tahap1' => collect(), 'tahap2' => collect()];
        $tahap1Keywords = ['tahap 1','tahap1','sesi 1','sesi1','sesi-1'];
        $tahap2Keywords = ['tahap 2','tahap2','sesi 2','sesi2','sesi-2'];
        foreach ($sesis as $sesi) {
            // prefer explicit stage field on sesi
            if (!empty($sesi->stage)) {
                $st = strtolower(trim($sesi->stage));
                if ($st === 'tahap1') { $tahapSessions['tahap1']->push($sesi); continue; }
                if ($st === 'tahap2') { $tahapSessions['tahap2']->push($sesi); continue; }
            }

            $name = strtolower(trim($sesi->nama_sesi ?? ''));
            $isTahap1 = false;
            foreach ($tahap1Keywords as $k) {
                if (strpos($name, $k) !== false) { $isTahap1 = true; break; }
            }
            if ($isTahap1) {
                $tahapSessions['tahap1']->push($sesi);
                continue;
            }
            $isTahap2 = false;
            foreach ($tahap2Keywords as $k) {
                if (strpos($name, $k) !== false) { $isTahap2 = true; break; }
            }
            if ($isTahap2) {
                $tahapSessions['tahap2']->push($sesi);
                continue;
            }
            // default: push to tahap1
            $tahapSessions['tahap1']->push($sesi);
        }

        if (request()->routeIs('kurikulum.*')) {
            return view('kurikulum.ppdb.jurusan.show', compact('jurusan', 'sesis', 'jalurs'));
        }

        return view('tu.ppdb.jurusan.show', compact('jurusan', 'sesis', 'jalurs', 'tahapSessions'));
    }

    // =========================
    // SHOW SEMUA PENDAFTAR JURUSAN
    // =========================
    public function showPendaftarJurusan($id)
    {
        $jurusan = Jurusan::findOrFail($id);

        $pendaftars = Ppdb::with(['jalur', 'sesi', 'jurusan'])
            ->where('jurusan_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        if (request()->routeIs('kurikulum.*')) {
            return view('kurikulum.ppdb.jurusan.pendaftar-jurusan', compact('jurusan', 'pendaftars'));
        }

        return view('tu.ppdb.jurusan.pendaftar-jurusan', compact('jurusan', 'pendaftars'));
    }

    // =========================
    // SHOW PENDAFTAR BERDASARKAN JURUSAN + SESI
    // =========================
    public function showPendaftarSesi($jurusanId, $sesiId)
    {
        $jurusan = Jurusan::findOrFail($jurusanId);
        $sesi = SesiPpdb::findOrFail($sesiId);

        $pendaftars = Ppdb::with(['jalur', 'sesi', 'jurusan'])
            ->where('jurusan_id', $jurusanId)
            ->where('sesi_ppdb_id', $sesiId)
            ->orderBy('created_at', 'desc')
            ->get();

        if (request()->routeIs('kurikulum.*')) {
            return view('kurikulum.ppdb.jurusan.pendaftar-sesi', compact('jurusan', 'sesi', 'pendaftars'));
        }

        return view('tu.ppdb.jurusan.pendaftar-sesi', compact('jurusan', 'sesi', 'pendaftars'));
    }

    // =========================
    // SHOW PENDAFTAR BERDASARKAN JURUSAN + JALUR
    // =========================
    public function showPendaftarJalur($jurusanId, $jalurId)
    {
        $jurusan = Jurusan::findOrFail($jurusanId);
        $jalur = JalurPpdb::findOrFail($jalurId);

        $pendaftars = Ppdb::with(['jalur', 'sesi', 'jurusan'])
            ->where('jurusan_id', $jurusanId)
            ->where('jalur_ppdb_id', $jalurId)
            ->orderBy('created_at', 'desc')
            ->get();

        if (request()->routeIs('kurikulum.*')) {
            return view('kurikulum.ppdb.jurusan.pendaftar-jalur', compact('jurusan', 'jalur', 'pendaftars'));
        }

        return view('tu.ppdb.jurusan.pendaftar-jalur', compact('jurusan', 'jalur', 'pendaftars'));
    }

    // =========================
    // SHOW PENDAFTAR BERDASARKAN SESI + JALUR (KURIKULUM)
    // =========================
    public function showPendaftarSesiJalur($sesiId, $jalurId)
    {
        $sesi = SesiPpdb::findOrFail($sesiId);
        $jalur = JalurPpdb::findOrFail($jalurId);

        $pendaftars = Ppdb::with(['jalur', 'sesi', 'jurusan'])
            ->where('sesi_ppdb_id', $sesiId)
            ->where('jalur_ppdb_id', $jalurId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kurikulum.ppdb.sesi_jalur_pendaftar', compact('sesi', 'jalur', 'pendaftars'));
    }

    // =========================
    // SHOW PENDAFTAR BERDASARKAN JURUSAN + SESI + JALUR (KURIKULUM)
    // =========================
    public function showPendaftarJurusanSesiJalur($jurusanId, $sesiId, $jalurId)
    {
        $jurusan = Jurusan::findOrFail($jurusanId);
        $sesi = SesiPpdb::findOrFail($sesiId);
        $jalur = JalurPpdb::findOrFail($jalurId);

        $pendaftars = Ppdb::with(['jalur', 'sesi', 'jurusan'])
            ->where('jurusan_id', $jurusanId)
            ->where('sesi_ppdb_id', $sesiId)
            ->where('jalur_ppdb_id', $jalurId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kurikulum.ppdb.jurusan.pendaftar-jalur', compact('jurusan', 'sesi', 'jalur', 'pendaftars'));
    }

    // =========================
    // FORM INPUT PPDB (PUBLIC)
    // =========================
    public function create(Request $request)
    {
        $allSesis = SesiPpdb::orderBy('tahun_ajaran', 'desc')->get();

        if (Schema::hasTable('ppdb_timelines')) {
            $opens = PpdbTimeline::pluck('open', 'stage')->toArray();
            $hasTahap1 = !empty($opens['tahap1']);
            $hasTahap2 = !empty($opens['tahap2']);

            $sesis = $allSesis->filter(function($s) use ($hasTahap1, $hasTahap2) {
                // prefer explicit stage on sesi
                if (!empty($s->stage)) {
                    $st = strtolower(trim($s->stage));
                    if ($st === 'tahap1') return $hasTahap1;
                    if ($st === 'tahap2') return $hasTahap2;
                    return false;
                }

                $name = strtolower($s->nama_sesi ?? '');
                $isTahap1 = (strpos($name, 'tahap 1') !== false || strpos($name, 'tahap1') !== false || strpos($name, 'sesi 1') !== false || strpos($name, 'sesi1') !== false);
                $isTahap2 = (strpos($name, 'tahap 2') !== false || strpos($name, 'tahap2') !== false || strpos($name, 'sesi 2') !== false || strpos($name, 'sesi2') !== false);

                if ($hasTahap1 && $hasTahap2) return true;
                if ($hasTahap1 && !$hasTahap2) return $isTahap1;
                if ($hasTahap2 && !$hasTahap1) return $isTahap2;
                return false;
            })->values();
        } else {
            $sesis = $allSesis;
        }

        return view('ppdb.create', [
            'sesi'        => $request->filled('sesi')  ? SesiPpdb::find($request->sesi)  : null,
            'jalur'       => $request->filled('jalur') ? JalurPpdb::find($request->jalur) : null,
            'jurusan'     => $request->filled('jurusan') ? Jurusan::find($request->jurusan) : null,
            'sesis'       => $sesis,
            'jalurs'      => JalurPpdb::orderBy('nama_jalur')->get(),
            'jurusans'    => Jurusan::orderBy('nama')->get(),
        ]);
    }

    // =========================
    // SIMPAN DATA PPDB (PUBLIC)
    // =========================
    public function store(Request $request)
    {
        Log::info('PPDB store called', $request->all());
        $validated = $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'nisn'           => 'nullable|string|max:30',
            'jenis_kelamin'  => 'required|in:L,P,Laki-laki,Perempuan',
            'tempat_lahir'   => 'nullable|string|max:100',
            'tanggal_lahir'  => 'nullable|date',
            'alamat'         => 'nullable|string',

            'jalur_ppdb_id'  => 'required|exists:jalur_ppdb,id',
            'sesi_ppdb_id'   => 'required|exists:sesi_ppdb,id',

            'jurusan_id'     => 'nullable|exists:jurusans,id',

            // File uploads
            'foto'         => 'required|array|min:1',
            'foto.*'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'kk'           => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'akta'         => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'ijazah'       => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'bukti_jalur'  => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        // NORMALISASI ENUM JK
        if ($validated['jenis_kelamin'] === 'L') {
            $validated['jenis_kelamin'] = 'Laki-laki';
        } elseif ($validated['jenis_kelamin'] === 'P') {
            $validated['jenis_kelamin'] = 'Perempuan';
        }

        // HANDLE FILE UPLOADS
        $filePaths = [];
        $files = ['kk', 'akta', 'ijazah', 'bukti_jalur'];

        // Handle single files
        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $uploadedFile = $request->file($file);
                $filename = time() . '_' . $file . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                $path = $uploadedFile->storeAs('ppdb/' . $file, $filename, 'public');
                $filePaths[$file] = $path;
            }
        }

        // Handle multiple foto files (take only first one)
        if ($request->hasFile('foto')) {
            $fotoFiles = $request->file('foto');
            if (is_array($fotoFiles) && count($fotoFiles) > 0) {
                $firstFoto = $fotoFiles[0]; // Take only first foto
                $filename = time() . '_foto_' . uniqid() . '.' . $firstFoto->getClientOriginalExtension();
                $path = $firstFoto->storeAs('ppdb/foto', $filename, 'public');
                $filePaths['foto'] = $path;
            }
        }

        // SIMPAN DATA
        try {
            Ppdb::create(array_merge($validated, $filePaths, [
                'status' => 'diterima',
                'tanggal_diterima' => now()->toDateString(),
            ]));

            return redirect()
                ->route('ppdb.create')
                ->with('success', 'Data PPDB berhasil disimpan.');
        } catch (Throwable $e) {
            Log::error('PPDB store failed: ' . $e->getMessage(), [
                'input' => $request->all(),
            ]);

            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    // =========================
    // FORM ASSIGN ROMBEL (TU)
    // =========================
    public function showAssignForm($id)
    {
        $entry = Ppdb::with(['jurusan', 'sesi', 'jalur'])->findOrFail($id);
        // Only show rombels that belong to the same jurusan as the PPDB entry
        // and are for Kelas 10 (tingkat = 10)
        $rombels = Rombel::with(['kelas', 'guru'])
            ->whereHas('kelas', function($q) use ($entry) {
                $q->where('jurusan_id', $entry->jurusan_id)
                  ->where(function($q2) {
                      $q2->where('tingkat', 10)
                         ->orWhere('tingkat', '10')
                         ->orWhere('tingkat', 'X')
                         ->orWhere('tingkat', 'x');
                  });
            })
            ->orderBy('nama')
            ->get();

        if (request()->routeIs('kurikulum.*')) {
            return view('kurikulum.ppdb.assign', compact('entry', 'rombels'));
        }

        return view('tu.ppdb.assign', compact('entry', 'rombels'));
    }

    // =========================
    // PROSES ASSIGN & BUAT AKUN (TU)
    // =========================
    public function assign(Request $request, $id)
    {
        $entry = Ppdb::findOrFail($id);

        $data = $request->validate([
            'rombel_id' => 'required|exists:rombels,id',
            'nis' => 'nullable|alpha_num|max:20',
        ]);

        $rombel = Rombel::findOrFail($data['rombel_id']);

        // Generate NIS
        if (!empty($data['nis'])) {
            $provided = preg_replace('/\D/', '', $data['nis']);
            $nis_candidate = str_pad($provided, 6, '0', STR_PAD_LEFT);
            if (DataSiswa::where('nis', $nis_candidate)->exists()) {
                return back()->withErrors(['nis' => 'NIS sudah digunakan'])->withInput();
            }
            $nis = $nis_candidate;
        } else {
            $max = DataSiswa::whereNotNull('nis')->max(DB::raw('CAST(nis AS UNSIGNED)'));
            $next = ($max ? intval($max) + 1 : intval(date('Y')) * 1000 + 1);
            $nis = str_pad($next, 6, '0', STR_PAD_LEFT);
            
            // Double-check NIS is unique
            while (DataSiswa::where('nis', $nis)->exists()) {
                $next++;
                $nis = str_pad($next, 6, '0', STR_PAD_LEFT);
            }
        }
        
        // Validate NISN is unique if provided
        if ($entry->nisn && DataSiswa::where('nisn', $entry->nisn)->exists()) {
            return back()->withErrors(['nisn' => 'NISN ' . $entry->nisn . ' sudah terdaftar di sistem.'])->withInput();
        }

        // Create parent records
        $ayahId = null;
        $ibuId = null;
        $waliId = null;

        if (!empty($entry->nama_ayah) || !empty($entry->pekerjaan_ayah)) {
            $ayah = Ayah::create([
                'nama' => $entry->nama_ayah,
                'pekerjaan' => $entry->pekerjaan_ayah ?? null,
                'telepon' => null,
                'alamat' => null,
            ]);
            $ayahId = $ayah->id;
        }

        if (!empty($entry->nama_ibu) || !empty($entry->pekerjaan_ibu)) {
            $ibu = Ibu::create([
                'nama' => $entry->nama_ibu,
                'pekerjaan' => $entry->pekerjaan_ibu ?? null,
                'telepon' => null,
                'alamat' => null,
            ]);
            $ibuId = $ibu->id;
        }

        // Create DataSiswa record
        DB::beginTransaction();
        try {
            $siswa = DataSiswa::create([
                'nama_lengkap'    => $entry->nama_lengkap,
                'nis'             => $nis,
                'nisn'            => $entry->nisn, // Simpan nisn di data_siswa saja
                'tempat_lahir'    => $entry->tempat_lahir ?? '-',
                'tanggal_lahir'   => $entry->tanggal_lahir ?? now()->toDateString(),
                'jenis_kelamin'   => $entry->jenis_kelamin ?? '-',
                'alamat'          => $entry->alamat ?? '-',
                'sekolah_asal'    => '-',
                'tanggal_diterima' => now()->toDateString(),
                'rombel_id'       => $rombel->id,
                'ayah_id'         => $ayahId,
                'ibu_id'          => $ibuId,
                'wali_id'         => $waliId,
            ]);

            // Buat User untuk siswa - password awal default '12345678'
            $defaultPassword = '12345678';
            $user = User::create([
                'name'         => $siswa->nama_lengkap,
                'nomor_induk'  => $nis,
                'role'         => 'siswa',
                'email'        => null,
                'password'     => bcrypt($defaultPassword),
            ]);

            // Hubungkan user dengan data siswa
            if (Schema::hasColumn('data_siswa', 'user_id')) {
                $siswa->update(['user_id' => $user->id]);
            }

            // Update PPDB entry
            $entry->update([
                'rombel_id' => $rombel->id,
                'kelas_id'  => $rombel->kelas_id,
                'status'    => 'aktif',
                'tanggal_diterima' => $entry->tanggal_diterima ?? now()->toDateString(),
            ]);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Assign PPDB failed: ' . $e->getMessage(), ['ppdb_id' => $entry->id]);
            return back()->withInput()->withErrors(['error' => 'Gagal assign: ' . $e->getMessage()]);
        }

        // Berikan informasi login ke admin
        $redirectRoute = request()->routeIs('kurikulum.*') ? 'kurikulum.ppdb.index' : 'tu.ppdb.index';

        return redirect()->route($redirectRoute)
            ->with('success', "PPDB terassign ke rombel {$rombel->nama} dan NIS dibuat: {$nis}.<br>
        Akun login telah dibuat:<br>
        Username: {$nis}<br>
        Password: 12345678<br>
        <small>Informasikan ke siswa untuk segera mengganti password</small>");
    }
    // =========================
    // AJAX AUTOFILL DATA ORANG TUA
    // =========================
    public function fetchDataSiswa($id)
    {
        $s = DataSiswa::findOrFail($id);

        return response()->json([
            'nama_ayah'       => $s->ayah->nama ?? '',
            'pekerjaan_ayah'  => $s->ayah->pekerjaan ?? '',
            'nama_ibu'        => $s->ibu->nama ?? '',
            'pekerjaan_ibu'   => $s->ibu->pekerjaan ?? '',
            'alamat_orangtua' => $s->alamat ?? '',
            'no_hp'           => $s->no_hp ?? '',
        ]);
    }
}
