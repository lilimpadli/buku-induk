<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Guru;
use App\Models\DataSiswa;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Rombel;
use App\Models\Jurusan;

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

            // Apply kelas filter (10/11/12)
            if ($kelasFilter) {
                if ($kelasFilter == '12') {
                    $siswasQuery->where('kelas', 'like', 'XII%');
                } elseif ($kelasFilter == '11') {
                    $siswasQuery->where('kelas', 'like', 'XI%')->where('kelas', 'not like', 'XII%');
                } elseif ($kelasFilter == '10') {
                    // kelas yang bukan XI atau XII, assume starts with 'X' but not XI/XII
                    $siswasQuery->where('kelas', 'like', 'X%')
                        ->where('kelas', 'not like', 'XI%')
                        ->where('kelas', 'not like', 'XII%');
                }
            }

            $siswas = $siswasQuery->orderBy('nama_lengkap')->get();

            $totalSiswa = $siswas->count();

            // Total kelas (kelas table untuk jurusan)
            $totalKelas = Kelas::where('jurusan_id', $jurusanId)->count();

            // Total rombel yang terhubung ke kelas jurusan ini
            $totalRombel = Rombel::whereHas('kelas', function ($q) use ($jurusanId) {
                $q->where('jurusan_id', $jurusanId);
            })->count();

            // Total guru di jurusan
            $totalGuru = Guru::where('jurusan_id', $jurusanId)->count();
        }

        return view('kaprog.dashboard', compact('totalSiswa', 'totalKelas', 'totalGuru', 'totalRombel', 'siswas', 'jurusan'));
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

        $user->save();

        return redirect()->route('kaprog.datapribadi.index')->with('success', 'Data diri berhasil diperbarui.');
    }
}
