<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\User;
use App\Imports\GuruImport;
use App\Exports\GuruExport;
use App\Exports\GuruImportTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

class ManajemenGuruController extends Controller
{
    // TAMPIL DATA
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

        return view('super_admin.manajemen-guru.index', compact('gurus', 'allJurusans', 'jurusan_id', 'search', 'allRoles', 'role'));
    }

    // FORM TAMBAH
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
            'guru'      => 'Guru',
            'walikelas' => 'Wali Kelas',
            'kaprog'    => 'Kaprog',
            'tu'        => 'TU',
            'kurikulum' => 'Kurikulum',
        ];

        return view('super_admin.manajemen-guru.create', compact(
            'jurusans',
            'kelas',
            'rombels',
            'roles',
            'kelasArr',
            'rombelArr'
        ));
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
        // sementara kosong dulu
        return redirect()->route('super_admin.manajemen-guru.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    // DETAIL
    public function show($id)
    {
        $guru = Guru::with(['rombels.kelas.jurusan', 'user'])->findOrFail($id);
        return view('super_admin.manajemen-guru.show', compact('guru'));
    }

    // FORM EDIT
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
            'guru'      => 'Guru',
            'walikelas' => 'Wali Kelas',
            'kaprog'    => 'Kaprog',
            'tu'        => 'TU',
            'kurikulum' => 'Kurikulum',
        ];

        return view('super_admin.manajemen-guru.edit', compact(
            'guru',
            'jurusans',
            'kelas',
            'rombels',
            'roles',
            'kelasArr',
            'rombelArr'
        ));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        return redirect()->route('super_admin.manajemen-guru.index')
            ->with('success', 'Data berhasil diupdate');
    }

    // HAPUS
    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('super_admin.manajemen-guru.index')
            ->with('success', 'Guru berhasil dihapus');
    }

    public function importForm()
    {
        return view('super_admin.manajemen-guru.import');
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
                    return redirect()->route('super_admin.manajemen-guru.index')
                        ->with('success', $message)
                        ->with('errors', $errors);
                }
                return redirect()->route('super_admin.manajemen-guru.index')
                    ->with('success', $message);
            } else {
                return redirect()->route('super_admin.manajemen-guru.importForm')
                    ->with('error', 'Tidak ada data guru yang berhasil diimport. ' . implode(', ', $errors));
            }
        } catch (\Exception $e) {
            return redirect()->route('super_admin.manajemen-guru.importForm')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        $search = $request->query('search', '');
        $jurusan_id = $request->query('jurusan', '');

        return Excel::download(new GuruExport($search, $jurusan_id), 'gurus.xlsx');
    }

    public function downloadTemplate()
    {
        return Excel::download(new GuruImportTemplateExport(), 'template_import_guru.xlsx');
    }
}