<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kurikulum;
use App\Models\MataPelajaran;
use App\Models\MutasiPegawai;
use App\Models\RiwayatKerja;
use App\Models\Dokumen;
use App\Imports\GuruImport;
use App\Exports\GuruTemplateExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TUKepegawaianController extends Controller
{
    protected static $guruTemplateFields = [
        'nama' => 'Nama',
        'nip' => 'NIP',
        'status_kepegawaian' => 'Status Kepegawaian',
        'pendidikan' => 'Pendidikan',
        'gelar_depan' => 'Gelar Depan',
        'gelar_belakang' => 'Gelar Belakang',
    ];

    // --- DASHBOARD ---
    public function dashboard()
    {
        $totalGuru = Guru::count();
        $totalTU = User::where('role', 'tu')->count();
        $totalTUKepegawaian = User::where('role', 'tu_kepegawaian')->count();
        $totalStaffAktif = User::whereIn('role', ['guru', 'tu', 'tu_kepegawaian'])->count();
        $guruBaru = Guru::with('user')->latest()->take(5)->get();

        return view('tu_kepegawaian.dashboard', compact('totalGuru', 'totalTU', 'totalTUKepegawaian', 'totalStaffAktif', 'guruBaru'));
    }

    // --- DATA GURU ---
    public function guruIndex(Request $request)
    {
        $query = Guru::with('user', 'jurusan')->orderBy('nama');
        $jurusans = Jurusan::orderBy('nama')->get();
        
        // Tambahkan ini agar error hilang
        $roleOptions = [
            'guru' => 'Guru', 
            'walikelas' => 'Wali Kelas', 
            'kaprog' => 'Kaprog', 
            'kurikulum' => 'Kurikulum'
        ];
        
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")->orWhere('nip', 'like', "%{$request->search}%");
            });
        }
        
        $gurus = $query->paginate(10)->withQueryString();
        
        // Pastikan $roleOptions dikirim di dalam compact()
        return view('tu_kepegawaian.guru.index', compact('gurus', 'jurusans', 'roleOptions'));
    }

    public function guruCreate()
    {
        $jurusans = Jurusan::orderBy('nama')->get();
        $roles = [
            'guru' => 'Guru',
            'walikelas' => 'Wali Kelas',
            'kaprog' => 'Kaprog',
            'kurikulum' => 'Kurikulum',
        ];

        return view('tu_kepegawaian.guru.create', compact('jurusans', 'roles'));
    }

    public function guruShow($id)
    {
        $guru = Guru::with(['user', 'jurusan', 'rombels.kelas.jurusan'])->findOrFail($id);
        return view('tu_kepegawaian.guru.show', compact('guru'));
    }

    public function guruEdit($id)
    {
        $guru = Guru::with(['user', 'jurusan'])->findOrFail($id);
        $jurusans = Jurusan::orderBy('nama')->get();
        $roles = [
            'guru' => 'Guru',
            'walikelas' => 'Wali Kelas',
            'kaprog' => 'Kaprog',
            'kurikulum' => 'Kurikulum',
        ];

        return view('tu_kepegawaian.guru.edit', compact('guru', 'jurusans', 'roles'));
    }

    public function guruStore(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required|unique:gurus,nip',
            'email' => 'nullable|email',
            'password' => 'required|confirmed',
            'status_kepegawaian' => 'nullable|in:PNS,PPPK,Honorer,Guru Tetap Yayasan,Guru Tidak Tetap',
            'pendidikan' => 'nullable|in:S1,S2,S3,D4,D3',
            'gelar_depan' => 'nullable|string|max:255',
            'gelar_belakang' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->nama,
                'nomor_induk' => $request->nip,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'guru',
            ]);
            Guru::create([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'jurusan_id' => $request->jurusan_id,
                'status_kepegawaian' => $request->status_kepegawaian,
                'pendidikan' => $request->pendidikan,
                'gelar_depan' => $request->gelar_depan,
                'gelar_belakang' => $request->gelar_belakang,
                'user_id' => $user->id,
            ]);
            DB::commit();
            return redirect()->route('tu_kepegawaian.guru.index')->with('success', 'Data berhasil ditambah');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function guruUpdate(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'nip' => 'required|unique:gurus,nip,' . $guru->id,
            'email' => 'nullable|email',
            'status_kepegawaian' => 'nullable|in:PNS,PPPK,Honorer,Guru Tetap Yayasan,Guru Tidak Tetap',
            'pendidikan' => 'nullable|in:S1,S2,S3,D4,D3',
            'gelar_depan' => 'nullable|string|max:255',
            'gelar_belakang' => 'nullable|string|max:255',
        ]);

        if ($guru->user) {
            $guru->user->update([
                'name' => $request->nama,
                'nomor_induk' => $request->nip,
                'email' => $request->email,
                'password' => $request->filled('password') ? Hash::make($request->password) : $guru->user->password,
            ]);
        }

        $guru->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'jurusan_id' => $request->jurusan_id,
            'status_kepegawaian' => $request->status_kepegawaian,
            'pendidikan' => $request->pendidikan,
            'gelar_depan' => $request->gelar_depan,
            'gelar_belakang' => $request->gelar_belakang,
        ]);

        return redirect()->route('tu_kepegawaian.guru.index')->with('success', 'Data berhasil diupdate');
    }

    public function guruDestroy($id) { Guru::findOrFail($id)->delete(); return back()->with('success', 'Data dihapus'); }

    public function guruTemplate(Request $request)
    {
        $selected = $request->query('fields', array_keys(self::$guruTemplateFields));
        $fields = array_values(array_intersect(array_keys(self::$guruTemplateFields), (array)$selected));
        if (empty($fields)) {
            $fields = array_keys(self::$guruTemplateFields);
        }

        return Excel::download(new GuruTemplateExport($fields), 'guru_template.xlsx');
    }

    public function guruImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx,csv',
        ]);

        $selectedColumns = array_values(array_filter((array)$request->input('selected_columns', [])));
        $map = array_filter((array)$request->input('map', []), fn($value) => trim($value) !== '');

        $import = new GuruImport();
        if (!empty($selectedColumns)) {
            $import->setSelectedColumns($selectedColumns);
        }
        if (!empty($map)) {
            $import->setColumnMap($map);
        }

        Excel::import($import, $request->file('file'));

        $errors = $import->getErrors();
        $successCount = $import->getSuccessCount();

        if (!empty($errors)) {
            return back()->with('error', 'Import selesai dengan beberapa peringatan.')->with('import_errors', $errors);
        }

        return back()->with('success', "Import berhasil. {$successCount} baris diproses.");
    }

    // --- DATA TU ---
    public function tuIndex() { $tu = User::whereIn('role', ['tu', 'tu_kepegawaian'])->paginate(10); return view('tu_kepegawaian.tu.index', compact('tu')); }
    public function tuDestroy($id) { User::findOrFail($id)->delete(); return back()->with('success', 'Data dihapus'); }

    // --- PENUGASAN ---
    public function dokumen() { $dokumens = Dokumen::all(); return view('tu_kepegawaian.dokumen.index', compact('dokumens')); }
    
    // --- RIWAYAT ---
    public function riwayat() { $riwayat = RiwayatKerja::all(); return view('tu_kepegawaian.riwayat.index', compact('riwayat')); }
    public function riwayatStore(Request $request)
    {
        $request->validate(['instansi' => 'required', 'jabatan' => 'required', 'mulai' => 'required|date']);
        RiwayatKerja::create($request->all());
        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    // --- MUTASI ---
    public function mutasiIndex() 
    { 
        $mutasis = \App\Models\MutasiPegawai::with('pegawai')->get(); 
        
        // DEBUG: Uncomment baris di bawah ini untuk melihat apakah data 'pegawai' ada isinya
        // dd($mutasis); 
        
        return view('tu_kepegawaian.mutasi.index', compact('mutasis')); 
    }

    // Pastikan hanya ada SATU fungsi ini di Controller
    public function mutasiCreate()
    {
        $gurus = \App\Models\Guru::all(); // Mengambil data guru
        return view('tu_kepegawaian.mutasi.create', compact('gurus'));
    }

    public function mutasiStore(Request $request)
    {
        // Validasi satu kali saja
        $request->validate([
            'guru_id' => 'required', 
            'jenis'   => 'required', 
            'tanggal' => 'required',
            'keterangan' => 'nullable'
        ]);

        \App\Models\MutasiPegawai::create($request->all());

        return redirect()->route('tu_kepegawaian.mutasi.index')
                        ->with('success', 'Data mutasi berhasil ditambahkan!');
    }


    public function mutasiEdit($id)
    {
        $mutasi = \App\Models\MutasiPegawai::findOrFail($id);
        // Sesuaikan dengan nama view edit Anda
        return view('tu_kepegawaian.mutasi.edit', compact('mutasi'));
    }

    public function mutasiDestroy($id)
    {
        $mutasi = \App\Models\MutasiPegawai::findOrFail($id);
        $mutasi->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }


    //mutasi update
    public function update(Request $request, $id)
    {
        $mutasi = \App\Models\MutasiPegawai::findOrFail($id);
        $mutasi->update([
            'jenis'      => $request->jenis,
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect('/tu_kepegawaian/mutasi')->with('success', 'Data berhasil diupdate!');
    }
  
    // -- Riwayat Kerja Pegawai --
    public function riwayatIndex()
    {
        $riwayat = \App\Models\RiwayatKerja::all(); 
        
        return view('tu_kepegawaian.riwayat.index', compact('riwayat'));
    }

    public function riwayatEdit($id)
    {
        $riwayat = \App\Models\RiwayatKerja::findOrFail($id);
        return view('tu_kepegawaian.riwayat.edit', compact('riwayat'));
    }

    public function riwayatUpdate(Request $request, $id)
    {
        $riwayat = \App\Models\RiwayatKerja::findOrFail($id);
        $riwayat->update($request->all());

        return redirect()->route('tu_kepegawaian.riwayat.index')
                        ->with('success', 'Data riwayat berhasil diupdate!');
    }

    public function riwayatDestroy($id)
    {
        $riwayat = \App\Models\RiwayatKerja::findOrFail($id);
        $riwayat->delete();

        return redirect()->route('tu_kepegawaian.riwayat.index')
                        ->with('success', 'Data riwayat berhasil dihapus!');
    }

    public function mutasiUpdate(Request $request, $id)
{
    $request->validate([
        'guru_id' => 'required',
        'jenis'   => 'required',
        'tanggal' => 'required',
    ]);

    $mutasi = \App\Models\MutasiPegawai::findOrFail($id);
    $mutasi->update($request->all());

    return redirect()->route('tu_kepegawaian.mutasi.index')
                     ->with('success', 'Data mutasi berhasil diupdate!');
}

public function dokumenIndex() 
{
    $dokumens = Dokumen::with('guru')->get();
    return view('tu_kepegawaian.dokumen.index', compact('dokumens'));
}

public function dokumenStore(Request $request) 
{
    $request->validate([
        'guru_id'      => 'required',
        'nama_dokumen' => 'required',
        'file'         => 'required|file|mimes:pdf,jpg,png|max:2048', // Batas 2MB
    ]);

    // Simpan file ke folder 'dokumen_pegawai' di storage
    $path = $request->file('file')->store('dokumen_pegawai', 'public');

    Dokumen::create([
        'guru_id'      => $request->guru_id,
        'nama_dokumen' => $request->nama_dokumen,
        'file_path'    => $path,
    ]);

    return redirect()->back()->with('success', 'Dokumen berhasil diupload!');
}

}