<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\User;
use App\Imports\GuruImport;
use App\Exports\GuruExport;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
   public function index(Request $request)
   {
       $search = $request->query('search', '');
       $jurusan_id = $request->query('jurusan', '');
       $role = $request->query('role', '');

       $allJurusans = Jurusan::orderBy('nama')->get();
       
       // Get all unique roles (guru, walikelas, kaprog) from users table
       $allRoles = User::distinct('role')
           ->whereIn('role', ['guru', 'walikelas', 'kaprog'])
           ->pluck('role')
           ->sort();

       $query = Guru::with(['rombels.kelas.jurusan', 'user'])
           ->orderBy('nama');

       if (!empty($search)) {
           $query->where(function($q) use ($search) {
               $q->where('nama', 'like', "%{$search}%")
                 ->orWhere('nip', 'like', "%{$search}%")
                 ->orWhere('email', 'like', "%{$search}%");
           });
       }

       if (!empty($jurusan_id)) {
           $query->where('jurusan_id', $jurusan_id);
       }

       if (!empty($role)) {
           $query->whereHas('user', function($q) use ($role) {
               $q->where('role', $role);
           });
       }

       $gurus = $query->paginate(15)->withQueryString();

       return view('kurikulum.guru.index', compact('gurus', 'allJurusans', 'jurusan_id', 'search', 'allRoles', 'role'));
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

    public function show($id)
    {
        $guru = Guru::with(['user', 'rombels.kelas.jurusan'])->findOrFail($id);
        return view('kurikulum.guru.show', compact('guru'));
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

    public function importForm()
    {
        return view('kurikulum.guru.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            $import = new GuruImport();
            Excel::import($import, $request->file('file'));

            $successCount = $import->getSuccessCount();
            $errors = $import->getErrors();

            if ($successCount > 0) {
                $message = "Berhasil import $successCount guru";
                if (count($errors) > 0) {
                    $message .= " dengan " . count($errors) . " error";
                    return redirect()->route('kurikulum.guru.index')
                        ->with('success', $message)
                        ->with('errors', $errors);
                }
                return redirect()->route('kurikulum.guru.index')
                    ->with('success', $message);
            } else {
                return redirect()->route('kurikulum.guru.importForm')
                    ->with('error', 'Tidak ada data guru yang berhasil diimport. ' . implode(', ', $errors));
            }
        } catch (\Exception $e) {
            return redirect()->route('kurikulum.guru.importForm')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        $search = $request->query('search', '');
        $jurusan_id = $request->query('jurusan', '');

        return Excel::download(new GuruExport($search, $jurusan_id), 'gurus.xlsx');
    }
}
