<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\User;
use App\Models\NilaiRaport;
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
        $totalKelas = DataSiswa::distinct('kelas')->count('kelas');
        
        // Data siswa terbaru
        $siswaBaru = DataSiswa::with('user')->latest()->take(5)->get();
        
        // Data wali kelas
        $waliKelas = User::where('role', 'walikelas')->get();
        
        // Statistik nilai raport
        $totalNilai = NilaiRaport::count();
        $nilaiTerbaru = NilaiRaport::with('siswa')->latest()->take(5)->get();
        
        return view('tu.dashboard', compact(
            'totalSiswa', 
            'totalWaliKelas', 
            'totalKelas',
            'siswaBaru',
            'waliKelas',
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
     * Halaman daftar wali kelas
     */
    public function waliKelas()
    {
        $waliKelas = User::where('role', 'walikelas')->paginate(10);
        return view('tu.wali-kelas', compact('waliKelas'));
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