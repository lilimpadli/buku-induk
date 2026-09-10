<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\Rombel;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;

class ManajemenSiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = DataSiswa::with([
            'user',
            'rombel.kelas'
        ]);

        // FILTER SEARCH
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%')
                  ->orWhere('nisn', 'like', '%' . $search . '%');
            });
        }

        // FILTER TINGKAT
        if ($request->filled('tingkat')) {
            $tingkat = $request->tingkat;

            $query->whereHas('rombel.kelas', function ($q) use ($tingkat) {
                $q->where('tingkat', $tingkat);
            });
        }

        // FILTER ROMBEL
        if ($request->filled('rombel')) {
            $query->where('rombel_id', $request->rombel);
        }

        $allRombels = Rombel::with('kelas')
            ->orderBy('nama')
            ->get();

        $allJurusans = Jurusan::orderBy('nama')->get();

        $siswas = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('super_admin.manajemen-siswa.index', [
            'siswas' => $siswas,
            'search' => $request->search,
            'filterRombel' => $request->rombel,
            'allRombels' => $allRombels,
            'allJurusans' => $allJurusans,
        ]);
    }

    public function create()
    {
        $rombels = Rombel::with('kelas.jurusan')->orderBy('nama')->get();
        $kelas = Kelas::with('jurusan')->orderBy('tingkat')->get();
        $jurusans = Jurusan::orderBy('nama')->get();

        return view('super_admin.manajemen-siswa.create', compact('rombels', 'kelas', 'jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'required|string|unique:data_siswa,nis',
            'nisn' => 'nullable|string|unique:data_siswa,nisn',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:50',
            'kewarganegaraan' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:20',
            'sekolah_asal' => 'nullable|string|max:255',
            'tanggal_diterima' => 'nullable|date',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'rombel_id' => 'nullable|exists:rombels,id',

            // ORANG TUA (FIELD LANGSUNG)
            'nama_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'telepon_ayah' => 'nullable|string|max:20',

            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'telepon_ibu' => 'nullable|string|max:20',

            'nama_wali' => 'nullable|string|max:255',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'telepon_wali' => 'nullable|string|max:20',

            'alamat' => 'nullable|string',
            'dusun' => 'nullable|string|max:100',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',

            'password' => 'nullable|confirmed|min:6',
        ]);

        $siswa = DataSiswa::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'kewarganegaraan' => $request->kewarganegaraan,
            'no_hp' => $request->no_hp,
            'sekolah_asal' => $request->sekolah_asal,
            'tanggal_diterima' => $request->tanggal_diterima,
            'rombel_id' => $request->rombel_id,

            // ORANG TUA (FIELD LANGSUNG)
            'nama_ayah' => $request->nama_ayah,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'telepon_ayah' => $request->telepon_ayah,

            'nama_ibu' => $request->nama_ibu,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
            'telepon_ibu' => $request->telepon_ibu,

            'nama_wali' => $request->nama_wali,
            'pekerjaan_wali' => $request->pekerjaan_wali,
            'telepon_wali' => $request->telepon_wali,

            'alamat' => $request->alamat,
            'dusun' => $request->dusun,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $request->kecamatan,
            'kode_pos' => $request->kode_pos,
        ]);

        // CREATE USER ACCOUNT
        if ($request->filled('password')) {
            $siswa->user()->create([
                'name' => $request->nama_lengkap,
                'email' => $request->nis . '@siswa.sch.id',
                'password' => bcrypt($request->password),
                'role' => 'siswa',
                'nomor_induk' => $request->nis,
            ]);
        }

        return redirect()->route('super_admin.manajemen-siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show($id)
    {
        $siswa = DataSiswa::with([
            'user',
            'rombel.kelas.jurusan'
        ])->findOrFail($id);

        return view('super_admin.manajemen-siswa.show', compact('siswa'));
    }

    public function edit($id)
    {
        $siswa = DataSiswa::with('rombel.kelas.jurusan')->findOrFail($id);

        $rombels = Rombel::with('kelas.jurusan')->orderBy('nama')->get();
        $kelas = Kelas::with('jurusan')->orderBy('tingkat')->get();
        $jurusans = Jurusan::orderBy('nama')->get();

        return view('super_admin.manajemen-siswa.edit', compact('siswa', 'rombels', 'kelas', 'jurusans'));
    }

    public function update(Request $request, $id)
    {
        $siswa = DataSiswa::with([
            'user'
        ])->findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'required|string|unique:data_siswa,nis,' . $id,
            'nisn' => 'nullable|string|unique:data_siswa,nisn,' . $id,
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:50',
            'kewarganegaraan' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:20',
            'sekolah_asal' => 'nullable|string|max:255',
            'tanggal_diterima' => 'nullable|date',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'rombel_id' => 'nullable|exists:rombels,id',

            'nama_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'telepon_ayah' => 'nullable|string|max:20',

            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'telepon_ibu' => 'nullable|string|max:20',

            'nama_wali' => 'nullable|string|max:255',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'telepon_wali' => 'nullable|string|max:20',

            'alamat' => 'nullable|string',
            'dusun' => 'nullable|string|max:100',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',

            'password' => 'nullable|confirmed|min:6',
        ]);

        $siswa->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'kewarganegaraan' => $request->kewarganegaraan,
            'no_hp' => $request->no_hp,
            'sekolah_asal' => $request->sekolah_asal,
            'tanggal_diterima' => $request->tanggal_diterima,
            'rombel_id' => $request->rombel_id,

            'nama_ayah' => $request->nama_ayah,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'telepon_ayah' => $request->telepon_ayah,

            'nama_ibu' => $request->nama_ibu,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
            'telepon_ibu' => $request->telepon_ibu,

            'nama_wali' => $request->nama_wali,
            'pekerjaan_wali' => $request->pekerjaan_wali,
            'telepon_wali' => $request->telepon_wali,

            'alamat' => $request->alamat,
            'dusun' => $request->dusun,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $request->kecamatan,
            'kode_pos' => $request->kode_pos,
        ]);

        // UPDATE PASSWORD USER
        if ($request->filled('password') && $siswa->user) {
            $siswa->user->update([
                'password' => bcrypt($request->password)
            ]);
        }

        // UPDATE USER NAME
        if ($siswa->user) {
            $siswa->user->update([
                'name' => $request->nama_lengkap,
                'nomor_induk' => $request->nis,
            ]);
        }

        return redirect()
            ->route('super_admin.manajemen-siswa.show', $siswa->id)
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = DataSiswa::findOrFail($id);

        // Hapus user terkait
        if ($siswa->user) {
            $siswa->user->delete();
        }

        $siswa->delete();

        return redirect()
            ->route('super_admin.manajemen-siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    public function exportByJurusan($jurusanId)
    {
        return redirect()->back()
            ->with('info', 'Fitur export sedang dalam pengembangan.');
    }

    public function exportByAngkatan($jurusanId)
    {
        return redirect()->back()
            ->with('info', 'Fitur export sedang dalam pengembangan.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        // TODO: Implement import logic

        return redirect()
            ->route('super_admin.manajemen-siswa.index')
            ->with('success', 'Data siswa berhasil diimport.');
    }
}