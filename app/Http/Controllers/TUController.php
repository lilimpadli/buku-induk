<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\User;
use App\Models\NilaiRaport;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TUController extends Controller
{
    /**
     * Dashboard TU
     */
    public function dashboard()
    {
        // Statistik dasar
        $totalSiswa = DataSiswa::count();
        $totalWaliKelas = User::where('role', 'walikelas')->count();
        $totalKelas = Kelas::count();
        
        // Data siswa terbaru
        $siswaBaru = DataSiswa::with('user')->latest()->take(5)->get();
        
        // Data wali kelas (untuk ditampilkan semua di bagian bawah)
        $waliKelas = User::where('role', 'walikelas')->get();
        
        // Data wali kelas dengan limit (untuk ringkasan)
        $waliKelasLimit = User::where('role', 'walikelas')->take(5)->get();
        
        // Data kelas dengan limit (untuk ringkasan)
        $kelasLimit = Kelas::with('jurusan')->take(5)->get();
        
        // Statistik nilai raport
        $totalNilai = NilaiRaport::count();
        $nilaiTerbaru = NilaiRaport::with('siswa')->latest()->take(5)->get();
        
        return view('tu.dashboard', compact(
            'totalSiswa', 
            'totalWaliKelas', 
            'totalKelas',
            'siswaBaru',
            'waliKelas',
            'waliKelasLimit',
            'kelasLimit',
            'totalNilai',
            'nilaiTerbaru'
        ));
    }
    
    /**
     * Halaman daftar siswa
     */
    public function siswa()
    {
        $siswas = DataSiswa::with('user')->latest()->paginate(10);
        return view('tu.siswa', compact('siswas'));
    }
    
    /**
     * Halaman tambah siswa
     */
    public function siswaCreate()
    {
        return view('tu.siswa-create');
    }
    
    /**
     * Simpan data siswa baru
     */
    public function siswaStore(Request $request)
    {
        $request->validate([
            'nama_lengkap'     => 'required|string|max:255',
            'nis'             => 'required|string|max:20|unique:data_siswa',
            'nisn'             => 'required|string|max:20|unique:data_siswa',
            'jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'     => 'required|string|max:255',
            'tanggal_lahir'    => 'required|date',
            'agama'            => 'required|string|max:50',
            'status_keluarga'  => 'nullable|string|max:100',
            'anak_ke'          => 'nullable|integer',
            'alamat'           => 'required|string',
            'no_hp'            => 'required|string|max:20',
            'sekolah_asal'     => 'nullable|string|max:255',
            'kelas'            => 'required|string|max:50',
            'tanggal_diterima' => 'nullable|date',

            // Orang tua
            'nama_ayah'        => 'required|string|max:255',
            'pekerjaan_ayah'   => 'required|string|max:255',
            'telepon_ayah'     => 'nullable|string|max:20',

            'nama_ibu'         => 'required|string|max:255',
            'pekerjaan_ibu'    => 'required|string|max:255',
            'telepon_ibu'      => 'nullable|string|max:20',

            // Wali
            'nama_wali'        => 'nullable|string|max:255',
            'alamat_wali'      => 'nullable|string',
            'telepon_wali'     => 'nullable|string|max:20',
            'pekerjaan_wali'   => 'nullable|string|max:255',
            
        ]);

        // Buat user account untuk siswa
        $user = User::create([
            'name' => $request->nama_lengkap,
            'nomor_induk' => $request->nis,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        // Simpan data siswa
        $siswa = new DataSiswa($request->all());
        $siswa->user_id = $user->id;
        $siswa->save();

        return redirect()->route('tu.siswa')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }
    
    /**
     * Halaman detail siswa
     */
    public function siswaDetail($id)
    {
        $siswa = DataSiswa::with('user', 'nilaiRaports')->findOrFail($id);
        return view('tu.siswa-detail', compact('siswa'));
    }
    
    /**
     * Halaman edit siswa
     */
    public function siswaEdit($id)
    {
        $siswa = DataSiswa::findOrFail($id);
        return view('tu.siswa-edit', compact('siswa'));
    }
    
    /**
     * Update data siswa
     */
    public function siswaUpdate(Request $request, $id)
    {
        $siswa = DataSiswa::findOrFail($id);
        
        $request->validate([
            'nama_lengkap'     => 'required|string|max:255',
            'nis'             => 'required|string|max:20|unique:data_siswa,nis,' . $id,
            'nisn'             => 'required|string|max:20|unique:data_siswa,nisn,' . $id,
            'jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'     => 'required|string|max:255',
            'tanggal_lahir'    => 'required|date',
            'agama'            => 'required|string|max:50',
            'status_keluarga'  => 'nullable|string|max:100',
            'anak_ke'          => 'nullable|integer',
            'alamat'           => 'required|string',
            'no_hp'            => 'required|string|max:20',
            'sekolah_asal'     => 'nullable|string|max:255',
            'kelas'            => 'required|string|max:50',
            'tanggal_diterima' => 'nullable|date',

            // Orang tua
            'nama_ayah'        => 'required|string|max:255',
            'pekerjaan_ayah'   => 'required|string|max:255',
            'telepon_ayah'     => 'nullable|string|max:20',

            'nama_ibu'         => 'required|string|max:255',
            'pekerjaan_ibu'    => 'required|string|max:255',
            'telepon_ibu'      => 'nullable|string|max:20',

            // Wali
            'nama_wali'        => 'nullable|string|max:255',
            'alamat_wali'      => 'nullable|string',
            'telepon_wali'     => 'nullable|string|max:20',
            'pekerjaan_wali'   => 'nullable|string|max:255',
        ]);

        $siswa->update($request->all());

        return redirect()->route('tu.siswa.detail', $id)
            ->with('success', 'Data siswa berhasil diperbarui.');
    }
    
    /**
     * Hapus data siswa
     */
    public function siswaDestroy($id)
    {
        $siswa = DataSiswa::findOrFail($id);
        
        // Hapus user terkait
        if ($siswa->user) {
            $siswa->user->delete();
        }
        
        // Hapus data siswa
        $siswa->delete();

        return redirect()->route('tu.siswa')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
    
    /**
     * Halaman daftar kelas
     */
    public function kelas()
    {
        $kelas = Kelas::with('jurusan')->get();
        return view('tu.kelas', compact('kelas'));
    }

    /**
     * Halaman tambah kelas
     */
    public function kelasCreate()
    {
        $jurusans = Jurusan::all();
        return view('tu.kelas-create', compact('jurusans'));
    }

    /**
     * Simpan data kelas baru
     */
    public function kelasStore(Request $request)
    {
        $request->validate([
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusans,id'
        ]);

        Kelas::create($request->all());
        
        return redirect()->route('tu.kelas')
            ->with('success', 'Data kelas berhasil ditambahkan.');
    }

    /**
     * Halaman detail kelas
     */public function kelasDetail($id)
{
    $kelas = Kelas::with([
        'jurusan',
        'rombels.siswa'
    ])->findOrFail($id);

    return view('tu.kelas-detail', compact('kelas'));
}


    /**
     * Halaman edit kelas
     */
    public function kelasEdit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $jurusans = Jurusan::all();
        return view('tu.kelas-edit', compact('kelas', 'jurusans'));
    }

    /**
     * Update data kelas
     */
    public function kelasUpdate(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        
        $request->validate([
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusans,id'
        ]);

        $kelas->update($request->all());

        return redirect()->route('tu.kelas.detail', $id)
            ->with('success', 'Data kelas berhasil diperbarui.');
    }

    /**
     * Hapus data kelas
     */
    public function kelasDestroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('tu.kelas')
            ->with('success', 'Data kelas berhasil dihapus.');
    }
    
    /**
     * Halaman daftar wali kelas
     */
 public function waliKelas()
{
    $waliKelas = User::where('role', 'walikelas')
                     ->with('rombels')
                     ->paginate(10);

    return view('tu.wali-kelas.index', compact('waliKelas'));
}



    /**
     * Halaman tambah wali kelas
     */
    public function waliKelasCreate()
    {
        return view('tu.wali-kelas-create');
    }

    /**
     * Simpan data wali kelas baru
     */
    public function waliKelasStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nomor_induk' => 'required|string|unique:users,nomor_induk',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'nomor_induk' => $request->nomor_induk,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'walikelas',
        ]);
        
        return redirect()->route('tu.wali-kelas')
            ->with('success', 'Data wali kelas berhasil ditambahkan.');
    }

    /**
     * Halaman edit wali kelas
     */
    public function waliKelasEdit($id)
    {
        $waliKelas = User::findOrFail($id);
        return view('tu.wali-kelas-edit', compact('waliKelas'));
    }

    /**
     * Update data wali kelas
     */
    public function waliKelasUpdate(Request $request, $id)
    {
        $waliKelas = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'nomor_induk' => 'required|string|unique:users,nomor_induk,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        $data = $request->all();
        
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $waliKelas->update($data);

        return redirect()->route('tu.wali-kelas.detail', $id)
            ->with('success', 'Data wali kelas berhasil diperbarui.');
    }

    /**
     * Hapus data wali kelas
     */
    public function waliKelasDestroy($id)
    {
        $waliKelas = User::findOrFail($id);
        $waliKelas->delete();

        return redirect()->route('tu.wali-kelas')
            ->with('success', 'Data wali kelas berhasil dihapus.');
    }
    
    /**
     * Halaman detail wali kelas
     */
    public function waliKelasDetail($id)
    {
        $waliKelas = User::findOrFail($id);
        $siswaCount = DataSiswa::count(); // Total siswa (bisa disesuaikan dengan kelas yang diampu)
        
        return view('tu.wali-kelas-detail', compact('waliKelas', 'siswaCount'));
    }
    
    /**
     * Halaman laporan nilai raport
     */
    public function laporanNilai()
    {
        $nilaiRaports = NilaiRaport::with('siswa')
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->paginate(20);
            
        return view('tu.laporan-nilai', compact('nilaiRaports'));
    }
}