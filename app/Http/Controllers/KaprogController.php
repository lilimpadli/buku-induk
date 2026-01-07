<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Guru;
use App\Models\DataSiswa;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Rombel;
use App\Models\Jurusan;
// imports cleaned: DataSiswa and Request already imported above
use App\Models\NilaiRaport;
use App\Models\EkstrakurikulerSiswa;
use App\Models\Kehadiran;
use App\Models\RaporInfo;

class KaprogController extends Controller
{
    // Dashboard khusus kaprog
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();
        $jurusanId = $guru ? $guru->jurusan_id : null;
        // Jika tidak ada jurusan terkait, kirimkan nol dan empty collections
        $q = $request->query('q');
        $kelasFilter = $request->query('kelas');

        if (! $jurusanId) {
            $totalSiswa = 0;
            $totalKelas = 0;
            $totalGuru = 0;
            $totalRombel = 0;
            $siswas = collect();
            $jurusan = null;
            $siswaKelas10 = $siswaKelas11 = $siswaKelas12 = 0;
            $rombelLabels = [];
            $rombelCounts = [];
        } else {
            $jurusan = Jurusan::find($jurusanId);

            // Base query: siswa yang rombel->kelas.jurusan_id = jurusanId
            $siswasQuery = DataSiswa::whereHas('rombel.kelas', function ($q) use ($jurusanId) {
                $q->where('jurusan_id', $jurusanId);
            });

            // Apply search query if provided (nama_lengkap or nis)
            if ($q) {
                $siswasQuery->where(function ($w) use ($q) {
                    $w->where('nama_lengkap', 'like', "%{$q}%")
                      ->orWhere('nis', 'like', "%{$q}%");
                });
            }

            // Apply kelas filter (10/11/12) using related rombel->kelas.tingkat
            if ($kelasFilter) {
                if (in_array($kelasFilter, ['10', '11', '12'])) {
                    $tingkatMap = ['10' => 'X', '11' => 'XI', '12' => 'XII'];
                    $desired = $tingkatMap[$kelasFilter];
                    $siswasQuery->whereHas('rombel.kelas', function ($kq) use ($desired, $jurusanId) {
                        $kq->where('tingkat', $desired);
                        if ($jurusanId) {
                            $kq->where('jurusan_id', $jurusanId);
                        }
                    });
                } elseif ($kelasFilter === 'all') {
                    // no extra filter
                }
            }

            $siswas = $siswasQuery->orderBy('nama_lengkap')->get();

            $totalSiswa = $siswas->count();

            // Chart data: jumlah siswa per tingkat (X/XI/XII) untuk jurusan
            $siswaKelas10 = DataSiswa::whereHas('rombel.kelas', function ($q) use ($jurusanId) {
                $q->where('tingkat', 'X')->where('jurusan_id', $jurusanId);
            })->count();

            $siswaKelas11 = DataSiswa::whereHas('rombel.kelas', function ($q) use ($jurusanId) {
                $q->where('tingkat', 'XI')->where('jurusan_id', $jurusanId);
            })->count();

            $siswaKelas12 = DataSiswa::whereHas('rombel.kelas', function ($q) use ($jurusanId) {
                $q->where('tingkat', 'XII')->where('jurusan_id', $jurusanId);
            })->count();

            // Chart data: rombel labels and siswa counts for the current jurusan
            $rombels = Rombel::whereHas('kelas', function ($q) use ($jurusanId) {
                $q->where('jurusan_id', $jurusanId);
            })->withCount('siswa')->get();

            $rombelLabels = $rombels->pluck('nama')->toArray();
            $rombelCounts = $rombels->pluck('siswa_count')->toArray();

            // Total kelas (kelas table untuk jurusan)
            $totalKelas = Kelas::where('jurusan_id', $jurusanId)->count();

            // Total rombel yang terhubung ke kelas jurusan ini
            $totalRombel = Rombel::whereHas('kelas', function ($q) use ($jurusanId) {
                $q->where('jurusan_id', $jurusanId);
            })->count();

            // Total guru di jurusan
            $totalGuru = Guru::where('jurusan_id', $jurusanId)->count();
        }

        return view('kaprog.dashboard', compact(
            'totalSiswa', 'totalKelas', 'totalGuru', 'totalRombel', 'siswas', 'jurusan',
            'siswaKelas10','siswaKelas11','siswaKelas12','rombelLabels','rombelCounts'
        ));
    }

    // Daftar siswa untuk kaprog (per angkatan tabs)
    public function siswaIndex(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();
        $jurusanId = $guru ? $guru->jurusan_id : null;

        $tingkats = ['X','XI','XII'];
        $byTingkat = [];

        foreach ($tingkats as $t) {
            $q = DataSiswa::with('rombel.kelas')
                ->whereHas('rombel.kelas', function ($q2) use ($t, $jurusanId) {
                    $q2->where('tingkat', $t);
                    if ($jurusanId) $q2->where('jurusan_id', $jurusanId);
                })
                ->orderBy('nama_lengkap');

            $byTingkat[$t] = $q->get();
        }

        return view('kaprog.siswa.index', ['studentsByTingkat' => $byTingkat]);
    }

    // Show detail siswa
    public function show($id)
    {
        $siswa = DataSiswa::with(['rombel.kelas.jurusan', 'ayah', 'ibu', 'wali'])->findOrFail($id);
        return view('kaprog.siswa.show', compact('siswa'));
    }

    // Halaman raport siswa untuk kaprog
    public function raportSiswa(Request $request)
    {
        $siswaId = $request->query('siswa_id');
        if (!$siswaId) {
            return redirect()->route('kaprog.siswa.index')->with('error', 'Pilih siswa terlebih dahulu untuk melihat raport.');
        }

        $siswa = DataSiswa::with('rombel.kelas.jurusan')->findOrFail($siswaId);

        // Cek apakah siswa di jurusan kaprog
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();
        if ($guru && $guru->jurusan_id && !$siswa->rombel || $siswa->rombel->kelas->jurusan_id != $guru->jurusan_id) {
            return redirect()->route('kaprog.siswa.index')->with('error', 'Akses ditolak');
        }

        // Ambil daftar tahun ajaran unik untuk siswa ini
        $raports = NilaiRaport::select('tahun_ajaran')
            ->where('siswa_id', $siswa->id)
            ->groupBy('tahun_ajaran')
            ->orderBy('tahun_ajaran', 'desc')
            ->get();

        return view('kaprog.siswa.raport', compact('siswa', 'raports'));
    }

    // Detail raport siswa per semester untuk kaprog
    public function raportShow($siswaId, $semester, $tahun)
    {
        $siswa = DataSiswa::with('rombel.kelas.jurusan')->findOrFail($siswaId);

        // Cek akses
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();
        if ($guru && $guru->jurusan_id && (!$siswa->rombel || $siswa->rombel->kelas->jurusan_id != $guru->jurusan_id)) {
            abort(403);
        }

        $tahun = str_replace('-', '/', $tahun);

        if (!in_array($semester, ['Ganjil', 'Genap'])) {
            return redirect()->back()->with('error', 'Semester tidak valid');
        }

        $nilaiRaports = NilaiRaport::with('mapel')
            ->where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->orderBy('mata_pelajaran_id')
            ->get();

        if ($nilaiRaports->isEmpty()) {
            return redirect()->back()->with('error', 'Data raport tidak ditemukan');
        }

        // Derive historical kelas/rombel from saved NilaiRaport rows so
        // we can show the class context as it was when the raport was recorded.
        $firstNilai = $nilaiRaports->first();
        $kelasRaport = $firstNilai->kelas ?? ($siswa->rombel->kelas ?? null);
        $rombelRaport = $firstNilai->rombel ?? ($siswa->rombel ?? null);

        $ekstra = EkstrakurikulerSiswa::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->get();

        $kehadiran = Kehadiran::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $raporInfo = RaporInfo::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        $kenaikan = \App\Models\KenaikanKelas::with('rombelTujuan')->where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->first();

        return view('kaprog.siswa.raport-detail', compact('siswa', 'nilaiRaports', 'ekstra', 'kehadiran', 'raporInfo', 'kenaikan', 'semester', 'tahun', 'kelasRaport', 'rombelRaport'));
    }

    // Tampilkan form data diri kaprog (edit)
    public function dataDiri()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();
        return view('kaprog.datapribadi.index', compact('user', 'guru'));
    }

    // Simpan perubahan data diri kaprog
    public function updateDataDiri(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|max:30',
            'alamat' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $request->validate(['photo' => 'nullable|image|max:2048']);

        if ($guru) {
            $guru->update($data);
        }

        // sinkron ke users.name dan email
        $user->name = $request->input('nama', $user->name);
        if ($request->filled('email')) $user->email = $request->input('email');

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('photos', 'public');
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $path;
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('kaprog.datapribadi.index')->with('success', 'Data diri berhasil diperbarui.');
    }
}
