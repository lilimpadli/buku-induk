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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Throwable;

class PpdbController extends Controller
{
    // =========================
    // HALAMAN PILIH SESI & JALUR (PUBLIC)
    // =========================
    public function index()
    {
        return view('ppdb.index', [
            'sesis'  => SesiPpdb::orderBy('tahun_ajaran', 'desc')->get(),
            'jalurs' => JalurPpdb::orderBy('nama_jalur')->get(),
        ]);
    }

    // =========================
    // DAFTAR PPDB UNTUK TU
    // =========================
    public function tuIndex()
    {
        $ppdbs = Ppdb::with(['jalur', 'sesi'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tu.ppdb.index', compact('ppdbs'));
    }

    // =========================
    // FORM INPUT PPDB (PUBLIC)
    // =========================
    public function create(Request $request)
    {
        return view('ppdb.create', [
            'sesi'        => $request->filled('sesi')  ? SesiPpdb::find($request->sesi)  : null,
            'jalur'       => $request->filled('jalur') ? JalurPpdb::find($request->jalur) : null,
            'sesis'       => SesiPpdb::orderBy('tahun_ajaran', 'desc')->get(),
            'jalurs'      => JalurPpdb::orderBy('nama_jalur')->get(),
            'jurusans'    => Jurusan::orderBy('nama')->get(),
        ]);
    }

    // =========================
    // SIMPAN DATA PPDB (PUBLIC)
    // =========================
    public function store(Request $request)
    {
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

            'nama_ayah'      => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'nama_ibu'       => 'nullable|string|max:255',
            'pekerjaan_ibu'  => 'nullable|string|max:255',
        ]);

        // NORMALISASI ENUM JK
        if ($validated['jenis_kelamin'] === 'L') {
            $validated['jenis_kelamin'] = 'Laki-laki';
        } elseif ($validated['jenis_kelamin'] === 'P') {
            $validated['jenis_kelamin'] = 'Perempuan';
        }

        // SIMPAN DATA
        try {
            Ppdb::create(array_merge($validated, [
                'status' => 'diterima',
            ]));

            return redirect()
                ->route('ppdb.index')
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
        $entry = Ppdb::findOrFail($id);
        $rombels = Rombel::with(['kelas', 'guru'])->orderBy('nama')->get();

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

            // Buat User untuk siswa - TANPA nisn
            $user = User::create([
                'name'         => $siswa->nama_lengkap,
                'nomor_induk'  => $nis,
                'role'         => 'siswa',
                'email'        => null,
                'password'     => bcrypt($nis), // Password awal = NIS
            ]);

            // Hubungkan user dengan data siswa
            if (Schema::hasColumn('data_siswa', 'user_id')) {
                $siswa->update(['user_id' => $user->id]);
            }

            // Update PPDB entry
            $entry->update([
                'rombel_id' => $rombel->id,
                'kelas_id'  => $rombel->kelas_id,
                'status'    => 'aktif'
            ]);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Assign PPDB failed: ' . $e->getMessage(), ['ppdb_id' => $entry->id]);
            return back()->withInput()->withErrors(['error' => 'Gagal assign: ' . $e->getMessage()]);
        }

        // Berikan informasi login ke admin
        return redirect()->route('tu.ppdb.index')
            ->with('success', "PPDB terassign ke rombel {$rombel->nama} dan NIS dibuat: {$nis}.<br>
        Akun login telah dibuat:<br>
        Username: {$nis}<br>
        Password: {$nis}<br>
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
