<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\Kurikulum;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TUKepegawaianController extends Controller
{
    /**
     * Dashboard TU Kepegawaian
     */
    public function dashboard()
    {
        // Statistik dasar untuk TU Kepegawaian
        $totalGuru = Guru::count();
        $totalTU = User::where('role', 'tu')->count();
        $totalTUKepegawaian = User::where('role', 'tu_kepegawaian')->count();
        $totalStaffAktif = User::whereIn('role', ['guru', 'tu', 'tu_kepegawaian'])->count();

        // Data guru terbaru
        $guruBaru = Guru::with('user')->latest()->take(5)->get();

        // Data aktivitas terbaru (simulasi)
        $aktivitas = [
            [
                'nama' => 'Ahmad Rizki',
                'jabatan' => 'Guru Matematika',
                'aktivitas' => 'Update data kepegawaian',
                'waktu' => '2 jam yang lalu'
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'jabatan' => 'TU Akademik',
                'aktivitas' => 'Penambahan data guru baru',
                'waktu' => '5 jam yang lalu'
            ],
            [
                'nama' => 'Budi Santoso',
                'jabatan' => 'TU Kepegawaian',
                'aktivitas' => 'Verifikasi data pegawai',
                'waktu' => '1 hari yang lalu'
            ]
        ];

        return view('tu_kepegawaian.dashboard', compact(
            'totalGuru',
            'totalTU',
            'totalTUKepegawaian',
            'totalStaffAktif',
            'guruBaru',
            'aktivitas'
        ));
    }

    /**
     * Index data guru
     */
    public function guruIndex(Request $request)
    {
        $query = Guru::with('user')->orderBy('nama');

        $search = $request->input('search');
        $jurusan_id = $request->input('jurusan');
        $role_filter = $request->input('role');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('nomor_induk', 'like', "%{$search}%");
                    });
            });
        }

        if ($jurusan_id) {
            $query->where('jurusan_id', $jurusan_id);
        }

        if ($role_filter) {
            $query->whereHas('user', function ($q) use ($role_filter) {
                $q->where('role', $role_filter);
            });
        }

        $allowedRoles = ['guru', 'walikelas', 'kaprog', 'kurikulum'];

        $query->whereHas('user', function ($q) use ($allowedRoles) {
            $q->whereIn('role', $allowedRoles);
        });

        $gurus = $query->paginate(10)->withQueryString();
        $jurusans = Jurusan::orderBy('nama')->get();
        $roleOptions = [
            'guru' => 'Guru',
            'walikelas' => 'Wali Kelas',
            'kaprog' => 'Kaprog',
            'kurikulum' => 'Kurikulum',
        ];

        return view('tu_kepegawaian.guru.index', compact(
            'gurus',
            'search',
            'jurusan_id',
            'role_filter',
            'jurusans',
            'roleOptions'
        ));
    }

    /**
     * Form tambah guru
     */
    public function guruCreate()
    {
        $jurusans = Jurusan::orderBy('nama')->get();

        $kelas = Kelas::with('jurusan')
            ->orderBy('tingkat')
            ->get();

        $rombels = Rombel::with(['kelas.jurusan'])
            ->orderBy('nama')
            ->get();

        $kelasArr = $kelas->map(function ($k) {
            return [
                'value' => (string) $k->id,
                'text' => $k->tingkat . ' - ' . ($k->jurusan->nama ?? ''),
                'jurusan' => (string) ($k->jurusan_id ?? ''),
            ];
        });

        $rombelArr = $rombels->map(function ($r) {
            return [
                'value' => (string) $r->id,
                'text' => $r->nama,
                'kelas' => (string) ($r->kelas_id ?? ''),
            ];
        });

        $roles = [
            'guru' => 'Guru',
            'walikelas' => 'Wali Kelas',
            'kaprog' => 'Kaprog',
            'kurikulum' => 'Kurikulum',
        ];

        return view('tu_kepegawaian.guru.create', compact(
            'jurusans',
            'kelas',
            'rombels',
            'roles',
            'kelasArr',
            'rombelArr'
        ));
    }

    /**
     * Simpan guru (user + guru)
     */
    public function guruStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nomor_induk' => 'required|string|max:50|unique:users,nomor_induk',
            'nip' => 'required|string|max:30|unique:gurus,nip',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'email' => 'nullable|email|unique:users,email',
            'telepon' => 'nullable|string|max:30',
            'role' => 'required|in:guru,walikelas,kaprog,kurikulum',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->nama,
                'nomor_induk' => $request->nomor_induk,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            $guru = Guru::create([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'email' => $request->email,
                'telepon' => $request->telepon ?? null,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'jurusan_id' => $request->jurusan_id,
                'user_id' => $user->id,
            ]);

            DB::commit();
            return redirect()->route('tu_kepegawaian.guru.index')->with('success', 'Guru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail guru
     */
    public function guruShow($id)
    {
        $guru = Guru::with(['user', 'rombels.kelas.jurusan'])->findOrFail($id);
        return view('tu_kepegawaian.guru.show', compact('guru'));
    }

    public function guruEdit($id)
    {
        $guru = Guru::with('user')->findOrFail($id);

        $jurusans = Jurusan::orderBy('nama')->get();

        $kelas = Kelas::with('jurusan')
            ->orderBy('tingkat')
            ->get();

        $rombels = Rombel::with(['kelas.jurusan'])
            ->orderBy('nama')
            ->get();

        $kelasArr = $kelas->map(function ($k) {
            return [
                'value' => (string) $k->id,
                'text' => $k->tingkat . ' - ' . ($k->jurusan->nama ?? ''),
                'jurusan' => (string) ($k->jurusan_id ?? ''),
            ];
        });

        $rombelArr = $rombels->map(function ($r) {
            return [
                'value' => (string) $r->id,
                'text' => $r->nama,
                'kelas' => (string) ($r->kelas_id ?? ''),
            ];
        });

        $roles = [
            'guru' => 'Guru',
            'walikelas' => 'Wali Kelas',
            'kaprog' => 'Kaprog',
            'kurikulum' => 'Kurikulum',
        ];

        return view('tu_kepegawaian.guru.edit', compact(
            'guru',
            'jurusans',
            'kelas',
            'rombels',
            'roles',
            'kelasArr',
            'rombelArr'
        ));
    }

    public function guruUpdate(Request $request, $id)
    {
        $guru = Guru::with('user')->findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_induk' => 'required|string|max:50|unique:users,nomor_induk,' . $guru->user_id,
            'nip' => 'required|string|max:30|unique:gurus,nip,' . $guru->id,
            'email' => 'nullable|email|unique:users,email,' . $guru->user_id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:guru,walikelas,kaprog,kurikulum',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'rombel_id' => 'nullable|exists:rombels,id',
        ]);

        $user = $guru->user;
        $user->name = $data['nama'];
        $user->nomor_induk = $data['nomor_induk'];
        $user->email = $data['email'] ?? null;
        $user->role = $data['role'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        $guru->update([
            'nama' => $data['nama'],
            'nip' => $data['nip'],
            'email' => $data['email'] ?? ($data['nomor_induk'] . '@no-reply.local'),
            'jurusan_id' => $data['jurusan_id'] ?? null,
            'kelas_id' => $data['kelas_id'] ?? null,
        ]);

        Rombel::where('guru_id', $guru->id)
            ->update(['guru_id' => null]);

        if (!empty($data['rombel_id'])) {
            $rombel = Rombel::find($data['rombel_id']);
            $rombel->guru_id = $guru->id;
            $rombel->save();

            $guru->rombel_id = $rombel->id;
        } else {
            $guru->rombel_id = null;
        }

        $guru->save();

        return redirect()->route('tu_kepegawaian.guru.index')->with('success', 'Guru berhasil diperbarui.');
    }

    public function guruDestroy($id)
    {
        $guru = Guru::findOrFail($id);

        if ($guru->user) {
            $guru->user->delete();
        }

        $guru->delete();

        return redirect()->route('tu_kepegawaian.guru.index')->with('success', 'Guru berhasil dihapus.');
    }

    /**
     * Index data TU
     */
    public function tuIndex(Request $request)
    {
        $query = User::whereIn('role', ['tu', 'tu_kepegawaian']);
        
        // Filter berdasarkan role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Filter berdasarkan search (nama atau nomor induk)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nomor_induk', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $tu = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('tu_kepegawaian.tu.index', compact('tu'));
    }

    public function tuCreate()
    {
        return view('tu_kepegawaian.tu.create');
    }

    public function tuStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'nomor_induk' => 'required|string|max:50|unique:users,nomor_induk',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'nomor_induk' => $request->nomor_induk,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'tu',
        ]);

        return redirect()->route('tu_kepegawaian.tu.index')->with('success', 'Akun TU berhasil dibuat.');
    }

    public function tuShow($id)
    {
        $user = User::findOrFail($id);
        return view('tu_kepegawaian.tu.show', compact('user'));
    }

    public function tuEdit($id)
    {
        $user = User::findOrFail($id);
        return view('tu_kepegawaian.tu.edit', compact('user'));
    }

    public function tuUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'nomor_induk' => 'required|string|max:50|unique:users,nomor_induk,' . $user->id,
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:tu,tu_kepegawaian',
        ]);

        $user->name = $request->name;
        $user->nomor_induk = $request->nomor_induk;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('tu_kepegawaian.tu.index')->with('success', 'Akun TU berhasil diperbarui.');
    }

    public function tuDestroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('tu_kepegawaian.tu.index')->with('success', 'Akun TU berhasil dihapus.');
    }

    // CRUD Kurikulum
    public function kurikulumIndex(Request $request)
    {
        $search = $request->get('search');

        $query = Kurikulum::query();

        if ($search) {
            $query->where('nama_kurikulum', 'like', '%' . $search . '%');
        }

        $kurikulum = $query->withCount('mataPelajarans')->orderBy('nama_kurikulum')->paginate(10)->withQueryString();

        return view('tu_kepegawaian.kurikulum.index', compact('kurikulum', 'search'));
    }

    public function kurikulumCreate()
    {
        return view('tu_kepegawaian.kurikulum.create');
    }

    public function kurikulumStore(Request $request)
    {
        $request->validate([
            'nama_kurikulum' => 'required|string|max:255|unique:kurikum,nama_kurikulum',
        ]);

        Kurikulum::create($request->only('nama_kurikulum'));

        return redirect()->route('tu_kepegawaian.kurikulum.index')->with('success', 'Kurikulum berhasil ditambahkan.');
    }

    public function kurikulumShow($id)
    {
        $kurikulum = Kurikulum::with('mataPelajarans')->findOrFail($id);
        return view('tu_kepegawaian.kurikulum.show', compact('kurikulum'));
    }

    public function kurikulumEdit($id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        return view('tu_kepegawaian.kurikulum.edit', compact('kurikulum'));
    }

    public function kurikulumUpdate(Request $request, $id)
    {
        $kurikulum = Kurikulum::findOrFail($id);

        $request->validate([
            'nama_kurikulum' => 'required|string|max:255|unique:kurikum,nama_kurikulum,' . $id,
        ]);

        $kurikulum->update($request->only('nama_kurikulum'));

        return redirect()->route('tu_kepegawaian.kurikulum.index')->with('success', 'Kurikulum berhasil diperbarui.');
    }

    public function kurikulumDestroy($id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        $kurikulum->delete();

        return redirect()->route('tu_kepegawaian.kurikulum.index')->with('success', 'Kurikulum berhasil dihapus.');
    }

    // CRUD Mata Pelajaran
    public function mataPelajaranIndex(Request $request)
    {
        $search = $request->get('search');
        $kurikulum_id = $request->get('kurikulum_id');
        $kelompok = $request->get('kelompok');

        $query = MataPelajaran::with(['kurikulums', 'jurusans']);

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        if ($kurikulum_id) {
            $query->whereHas('kurikulums', function ($q) use ($kurikulum_id) {
                $q->where('kurikulum_id', $kurikulum_id);
            });
        }

        if ($kelompok) {
            $query->where('kelompok', $kelompok);
        }

        $mataPelajarans = $query->orderBy('kelompok')->orderBy('urutan')->paginate(10)->withQueryString();
        $kurikulums = Kurikulum::orderBy('nama_kurikulum')->get();

        return view('tu_kepegawaian.mata-pelajaran.index', compact(
            'mataPelajarans',
            'search',
            'kurikulum_id',
            'kelompok',
            'kurikulums'
        ));
    }

    public function mataPelajaranCreate()
    {
        $kurikulums = Kurikulum::orderBy('nama_kurikulum')->get();
        $jurusans = Jurusan::orderBy('nama')->get();

        return view('tu_kepegawaian.mata-pelajaran.create', compact('kurikulums', 'jurusans'));
    }

    public function mataPelajaranStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelompok' => 'required|in:A,B',
            'urutan' => 'nullable|integer|min:1',
            'kurikulum_ids' => 'nullable|array',
            'kurikulum_ids.*' => 'exists:kurikum,id',
            'jurusan_ids' => 'nullable|array',
            'jurusan_ids.*' => 'exists:jurusans,id',
        ]);

        $mataPelajaran = MataPelajaran::create($request->only(['nama', 'kelompok', 'urutan']));

        // Sync kurikulum
        if ($request->has('kurikulum_ids')) {
            $mataPelajaran->kurikulums()->sync($request->kurikulum_ids);
        }

        // Sync jurusan
        if ($request->has('jurusan_ids')) {
            $mataPelajaran->jurusans()->sync($request->jurusan_ids);
        }

        return redirect()->route('tu_kepegawaian.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function mataPelajaranShow($id)
    {
        $mataPelajaran = MataPelajaran::with(['kurikulums', 'jurusans', 'tingkats', 'nilai'])->findOrFail($id);
        return view('tu_kepegawaian.mata-pelajaran.show', compact('mataPelajaran'));
    }

    public function mataPelajaranEdit($id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        $kurikulums = Kurikulum::orderBy('nama_kurikulum')->get();
        $jurusans = Jurusan::orderBy('nama')->get();

        return view('tu_kepegawaian.mata-pelajaran.edit', compact('mataPelajaran', 'kurikulums', 'jurusans'));
    }

    public function mataPelajaranUpdate(Request $request, $id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'kelompok' => 'required|in:A,B',
            'urutan' => 'nullable|integer|min:1',
            'kurikulum_ids' => 'nullable|array',
            'kurikulum_ids.*' => 'exists:kurikum,id',
            'jurusan_ids' => 'nullable|array',
            'jurusan_ids.*' => 'exists:jurusans,id',
        ]);

        $mataPelajaran->update($request->only(['nama', 'kelompok', 'urutan']));

        // Sync kurikulum
        $mataPelajaran->kurikulums()->sync($request->kurikulum_ids ?? []);

        // Sync jurusan
        $mataPelajaran->jurusans()->sync($request->jurusan_ids ?? []);

        return redirect()->route('tu_kepegawaian.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function mataPelajaranDestroy($id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        $mataPelajaran->delete();

        return redirect()->route('tu_kepegawaian.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}