<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\User;

class GuruController extends Controller
{
   public function index()
{
    $jurusans = Jurusan::with([
        'gurus.user',
        'gurus.rombels.kelas'
    ])->orderBy('nama')->get();

    return view('kurikulum.guru.index', compact('jurusans'));
}


    public function create()
    {
        $jurusans = Jurusan::orderBy('nama')->get();

        $kelas = \App\Models\Kelas::with('jurusan')
            ->orderBy('tingkat')
            ->get();

        $rombels = \App\Models\Rombel::with(['kelas.jurusan'])
            ->orderBy('nama')
            ->get();

        $kelasArr = $kelas->map(function($k){
            return [
                'value' => (string) $k->id,
                'text' => $k->tingkat . ' - ' . ($k->jurusan->nama ?? ''),
                'jurusan' => (string) ($k->jurusan_id ?? ''),
            ];
        });

        $rombelArr = $rombels->map(function($r){
            return [
                'value' => (string) $r->id,
                'text' => $r->nama,
                'kelas' => (string) ($r->kelas_id ?? ''),
            ];
        });

        $roles = [
            'walikelas' => 'Guru',
            'kaprog'    => 'Kaprog',
            'tu'        => 'TU',
            'kurikulum' => 'Kurikulum',
        ];

        return view('kurikulum.guru.create', compact(
            'jurusans',
            'kelas',
            'rombels',
            'roles',
            'kelasArr',
            'rombelArr'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'        => 'required|string|max:255',
            'nomor_induk' => 'required|string|max:50|unique:users,nomor_induk',
            'email'       => 'nullable|email',
            'password'    => 'required|string|min:6',
            'role'        => 'required|string',
            'jurusan_id'  => 'nullable|exists:jurusans,id',
            'kelas_id'    => 'nullable|exists:kelas,id',
            'rombel_id'   => 'nullable|exists:rombels,id',
        ]);

        $user = User::create([
            'name'        => $data['nama'],
            'nomor_induk' => $data['nomor_induk'],
            'email'       => $data['email'] ?? null,
            'role'        => $data['role'],
            'password'    => bcrypt($data['password']),
        ]);

        $guru = Guru::create([
            'nama'       => $data['nama'],
            'nip'        => $data['nomor_induk'],
            'email'      => $data['email'] ?? ($data['nomor_induk'] . '@no-reply.local'),
            'jurusan_id' => $data['jurusan_id'] ?? null,
            'kelas_id'   => $data['kelas_id'] ?? null,
            'rombel_id'  => null,
            'user_id'    => $user->id,
        ]);

        if (!empty($data['rombel_id'])) {
            \App\Models\Rombel::where('id', $data['rombel_id'])
                ->update(['guru_id' => $guru->id]);

            $guru->rombel_id = $data['rombel_id'];
            $guru->save();
        }

        return redirect()
            ->route('kurikulum.guru.manage.index')
            ->with('success', 'Guru berhasil ditambahkan');
    }

    /* =====================================================
     | EDIT (DIPERBAIKI)
     ===================================================== */
    public function edit($id)
{
    $guru = Guru::with('user')->findOrFail($id);

    $jurusans = Jurusan::orderBy('nama')->get();

    $kelas = \App\Models\Kelas::with('jurusan')
        ->orderBy('tingkat')
        ->get();

    $rombels = \App\Models\Rombel::with(['kelas.jurusan'])
        ->orderBy('nama')
        ->get();

    // ✅ TAMBAHAN WAJIB
    $kelasArr = $kelas->map(function ($k) {
        return [
            'value'   => (string) $k->id,
            'text'    => $k->tingkat . ' - ' . ($k->jurusan->nama ?? ''),
            'jurusan' => (string) ($k->jurusan_id ?? ''),
        ];
    });

    $rombelArr = $rombels->map(function ($r) {
        return [
            'value' => (string) $r->id,
            'text'  => $r->nama,
            'kelas' => (string) ($r->kelas_id ?? ''),
        ];
    });

    $roles = [
        'walikelas' => 'Guru',
        'kaprog'    => 'Kaprog',
        'tu'        => 'TU',
        'kurikulum' => 'Kurikulum',
    ];

    return view(
        'kurikulum.guru.edit',
        compact(
            'guru',
            'jurusans',
            'kelas',
            'rombels',
            'roles',
            'kelasArr',
            'rombelArr'
        )
    );
}


    /* =====================================================
     | UPDATE (DIPERBAIKI)
     ===================================================== */
    public function update(Request $request, $id)
    {
        $guru = Guru::with('user')->findOrFail($id);

        $data = $request->validate([
            'nama'        => 'required|string|max:255',
            'nomor_induk' => 'required|string|max:50|unique:users,nomor_induk,' . $guru->user_id,
            'email'       => 'nullable|email',
            'password'    => 'nullable|string|min:6',
            'role'        => 'required|string',
            'jurusan_id'  => 'nullable|exists:jurusans,id',
            'kelas_id'    => 'nullable|exists:kelas,id',
            'rombel_id'   => 'nullable|exists:rombels,id',
        ]);

        /* ========= USER ========= */
        $user = $guru->user;
        $user->name        = $data['nama'];
        $user->nomor_induk = $data['nomor_induk'];
        $user->email       = $data['email'] ?? null;
        $user->role        = $data['role'];

        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();

        /* ========= GURU ========= */
        $guru->update([
            'nama'       => $data['nama'],
            'nip'        => $data['nomor_induk'],
            'email'      => $data['email'] ?? ($data['nomor_induk'] . '@no-reply.local'),
            'jurusan_id' => $data['jurusan_id'] ?? null,
            'kelas_id'   => $data['kelas_id'] ?? null,
        ]);

        /* ========= SINKRON ROMBEL ========= */
        // lepas SEMUA rombel yang dulu dipegang guru ini
        \App\Models\Rombel::where('guru_id', $guru->id)
            ->update(['guru_id' => null]);

        if (!empty($data['rombel_id'])) {
            $rombel = \App\Models\Rombel::find($data['rombel_id']);
            $rombel->guru_id = $guru->id;
            $rombel->save();

            $guru->rombel_id = $rombel->id;
        } else {
            $guru->rombel_id = null;
        }

        $guru->save();

        return redirect()
            ->route('kurikulum.guru.manage.index')
            ->with('success', 'Guru berhasil diperbarui');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        if ($guru->user) {
            $guru->user->delete();
        }
        $guru->delete();

        return redirect()
            ->route('kurikulum.guru.manage.index')
            ->with('success', 'Guru berhasil dihapus');
    }
}
