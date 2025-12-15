<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use App\Models\Rombel;

class KaprogGuruController extends Controller
{
    // Tampilkan daftar guru di jurusan kaprog yang sedang login
    public function index(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->with('jurusan')->first();

        if (! $guru || ! $guru->jurusan) {
            return abort(403, 'Tidak dapat menentukan jurusan Anda.');
        }

        $jurusan = $guru->jurusan;

        // Ambil semua guru yang terdaftar pada jurusan ini, beserta user dan rombels (kelas + siswa)
        $gurus = Guru::with(['user', 'rombels.kelas', 'rombels.siswa'])
            ->where('jurusan_id', $jurusan->id)
            ->get();

        return view('kaprog.guru.index', compact('jurusan', 'gurus'));
    }

    // Tampilkan detail guru dan rombel yang dia ampu (terbatas pada jurusan kaprog)
    public function show($id)
    {
        $user = Auth::user();
        $kaprog = Guru::where('user_id', $user->id)->with('jurusan')->first();

        if (! $kaprog || ! $kaprog->jurusan) {
            return abort(403, 'Tidak dapat menentukan jurusan Anda.');
        }

        // Ambil guru dan rombels yang dia ampu (dengan hitungan siswa per rombel)
        $guru = Guru::with('user')
            ->where('id', $id)
            ->where('jurusan_id', $kaprog->jurusan->id)
            ->firstOrFail();

        $rombels = Rombel::with('kelas')
            ->withCount('siswa')
            ->where('guru_id', $guru->id)
            ->whereHas('kelas', function ($q) use ($kaprog) {
                $q->where('jurusan_id', $kaprog->jurusan->id);
            })
            ->get();

        return view('kaprog.guru.show', [
            'jurusan' => $kaprog->jurusan,
            'guru' => $guru,
            'rombels' => $rombels,
        ]);
    }
}
