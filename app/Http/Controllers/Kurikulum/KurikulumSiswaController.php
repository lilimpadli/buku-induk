<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\User;
use App\Models\Rombel;
use Illuminate\Http\Request;

class KurikulumSiswaController extends Controller
{
    public function index()
    {
        $siswa = DataSiswa::with(['user', 'ayah', 'ibu', 'wali', 'rombel'])
            ->latest()
            ->paginate(15);

        return view('kurikulum.siswa.index', compact('siswa'));
    }

    public function create()
    {
        $users = User::where('role', 'siswa')->get();
        $rombels = Rombel::all();
        return view('kurikulum.siswa.create', compact('users','rombels'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_lengkap' => 'required|string|max:255',
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
        ]);

        $user = User::find($data['user_id']);
        $data['nis'] = $user->nomor_induk;

        DataSiswa::create($data);

        return redirect()->route('kurikulum.siswa.index')->with('success', 'Data siswa ditambahkan.');
    }

    public function edit($id)
    {
        $siswa = DataSiswa::findOrFail($id);
        $users = User::where('role', 'siswa')->get();
        $rombels = Rombel::all();
        return view('kurikulum.siswa.edit', compact('siswa','users','rombels'));
    }

    public function update(Request $request, $id)
    {
        $siswa = DataSiswa::findOrFail($id);

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_lengkap' => 'required|string|max:255',
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
        ]);

        $user = User::find($data['user_id']);
        $data['nis'] = $user->nomor_induk;

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
        return view('kurikulum.siswa.show', compact('siswa'));
    }

    
}