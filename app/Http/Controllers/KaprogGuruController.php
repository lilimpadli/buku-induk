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

        // Ambil query dan terapkan pencarian jika ada
        $search = $request->query('search', '');

        $gurusQuery = Guru::with(['user', 'rombels.kelas', 'rombels.siswa'])
            ->where('jurusan_id', $jurusan->id);

        if ($search) {
            $gurusQuery->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('email', 'like', "%{$search}%");
                  });
            });
        }

        $gurus = $gurusQuery->orderBy('nama')->get();

        return view('kaprog.guru.index', compact('jurusan', 'gurus', 'search'));
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
