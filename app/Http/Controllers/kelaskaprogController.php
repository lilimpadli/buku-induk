<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rombel;
use App\Models\DataSiswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Validator;

class KelaskaprogController extends Controller
{
    // Tampilkan daftar rombel/kelas untuk kaprog
    public function index()
    {
        $user = Auth::user();
        $guru = $user ? Guru::where('user_id', $user->id)->first() : null;

        // Jika guru (kaprog) punya jurusan, tampilkan rombel untuk jurusan itu saja
        if ($guru && $guru->jurusan_id) {
            $jurusan = Jurusan::find($guru->jurusan_id);

            // Ambil rombel yang kelasnya termasuk dalam jurusan ini
            $rombels = Rombel::with('kelas')
                ->whereHas('kelas', function ($q) use ($guru) {
                    $q->where('jurusan_id', $guru->jurusan_id);
                })
                ->orderBy('nama')
                ->get();

            return view('kaprog.kelas.index', compact('jurusan', 'rombels'));
        }

        // Kalau tidak ada jurusan (admin/umum), tampilkan semua jurusan dan rombel per jurusan
        $jurusans = Jurusan::with(['kelas.rombels'])->orderBy('nama')->get();
        return view('kaprog.kelas.index', compact('jurusans'));
    }

    // Tampilkan detail rombel (siswa yang berada di rombel ini)
    public function show($id, Request $request)
    {
        $rombel = Rombel::with('kelas.jurusan')->findOrFail($id);

        // Get search dan filter params
        $search = $request->query('search', '');
        $filterJenisKelamin = $request->query('jenis_kelamin', '');

        // Ambil siswa di rombel ini, pastikan rombel->kelas->jurusan sesuai
        $siswaQuery = DataSiswa::with('rombel')
            ->where('rombel_id', $rombel->id)
            ->whereHas('rombel.kelas', function ($q) use ($rombel) {
                $q->where('jurusan_id', $rombel->kelas->jurusan_id);
            });

        // Apply search filter
        if ($search) {
            $siswaQuery->where(function ($w) use ($search) {
                $w->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        // Apply jenis kelamin filter
        if ($filterJenisKelamin) {
            // The stored values may be 'L'/'P' or full labels; try both
            $siswaQuery->where(function($q) use ($filterJenisKelamin) {
                $q->where('jenis_kelamin', $filterJenisKelamin)
                  ->orWhere('jenis_kelamin', $filterJenisKelamin == 'Laki-laki' ? 'L' : ($filterJenisKelamin == 'Perempuan' ? 'P' : null));
            });
        }

        $siswa = $siswaQuery->orderBy('nama_lengkap')->get();

        return view('kaprog.kelas.show', compact('rombel', 'siswa', 'search', 'filterJenisKelamin'));
    }

    // Tampilkan daftar siswa berdasarkan angkatan/tingkat (X, XI, XII)
    public function angkatan($tingkat)
    {
        $user = Auth::user();
        $guru = $user ? Guru::where('user_id', $user->id)->first() : null;

        $siswa = DataSiswa::with(['rombel.kelas', 'ayah', 'ibu', 'wali'])
            ->whereHas('rombel.kelas', function ($q) use ($tingkat, $guru) {
                $q->where('tingkat', $tingkat);
                if ($guru && $guru->jurusan_id) {
                    $q->where('jurusan_id', $guru->jurusan_id);
                }
            })
            ->orderBy('nama_lengkap')
            ->get();

        return view('kaprog.kelas.angkatan', compact('tingkat', 'siswa'));
    }

    // Terima laporan/komentar tentang siswa dari kaprog (simpan di `catatan_wali_kelas`)
    public function lapor(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'lapor' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $siswa = DataSiswa::findOrFail($id);
        $user = Auth::user();
        $note = now()->format('Y-m-d H:i') . ' - ' . ($user->name ?? 'Kaprog') . ': ' . $request->input('lapor');

        $siswa->catatan_wali_kelas = trim(($siswa->catatan_wali_kelas ? $siswa->catatan_wali_kelas . "\n" : '') . $note);
        $siswa->save();

        return redirect()->back()->with('success', 'Laporan berhasil dikirim.');
    }
}

