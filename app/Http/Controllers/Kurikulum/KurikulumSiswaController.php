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
use Illuminate\Database\QueryException;

class KurikulumSiswaController extends Controller
{
    public function index()
    {
        $siswas = DataSiswa::with(['user', 'ayah', 'ibu', 'wali', 'rombel'])
            ->latest()
            ->paginate(15);

        return view('kurikulum.siswa.index', compact('siswas'));
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
        $users = User::where('role', 'siswa')->get();
        $rombels = Rombel::all();
        $kelas = Kelas::with('jurusan')->get();
        $jurusans = Jurusan::all();

        return view('kurikulum.siswa.edit', compact('siswa','users','rombels','kelas','jurusans'));
    }

    public function update(Request $request, $id)
    {
        $siswa = DataSiswa::findOrFail($id);
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

        if (empty($data['user_id'])) {
            // keep existing associated user
            $data['user_id'] = $siswa->user_id;
            $user = User::find($data['user_id']);
        } else {
            $user = User::find($data['user_id']);
        }

        $data['nis'] = $request->input('nis') ?? $user->nomor_induk ?? $siswa->nis;

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