<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\User;
use App\Models\NilaiRaport;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Ayah;
use App\Models\Ibu;
use App\Models\Wali;
use App\Models\WaliKelas;
use App\Models\Rombel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Guru;
use Illuminate\Support\Facades\Validator;

class TUController extends Controller
{
    /**
     * Dashboard TU
     */
   public function dashboard()
{
    // Statistik dasar
     $totalSiswa = DataSiswa::count();
    $totalGuru = User::where('role', 'guru')->count(); // Ubah dari totalWaliKelas
    $totalWaliKelas = User::where('role', 'walikelas')->count(); // <-- added
    $totalKelas = Kelas::count();
    // Jumlah wali kelas (dibutuhkan oleh view tu.dashboard)
    $totalWaliKelas = User::where('role', 'walikelas')->count();
    
    // Inisialisasi variabel jurusan untuk menghindari error
    $jurusan = null;
    
    // Data aktivitas terbaru
    $aktivitas = [
        [
            'nama' => 'Ahmad Rizki',
            'kelas' => 'XII RPL 1',
            'aktivitas' => 'Penambahan data nilai',
            'waktu' => '2 jam yang lalu'
        ],
        [
            'nama' => 'Siti Nurhaliza',
            'kelas' => 'XI TKJ 2',
            'aktivitas' => 'Update profil siswa',
            'waktu' => '5 jam yang lalu'
        ],
        [
            'nama' => 'Budi Santoso',
            'kelas' => 'X MM 1',
            'aktivitas' => 'Pengajuan pindah kelas',
            'waktu' => '1 hari yang lalu'
        ]
    ];
    
    // Data siswa terbaru
    $siswaBaru = DataSiswa::with(['user', 'ayah', 'ibu', 'wali'])->latest()->take(5)->get();
    
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
        'totalGuru', // Ubah dari totalWaliKelas
        'totalWaliKelas', // <-- added
        'totalKelas',
        'totalWaliKelas',
        'jurusan', // Tambahkan ini
        'aktivitas', // Tambahkan ini
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
        $siswas = DataSiswa::with(['user', 'ayah', 'ibu', 'wali'])->latest()->paginate(10);
        return view('tu.siswa', compact('siswas'));
    }

    /**
     * Daftar guru untuk TU
     */
    public function guruIndex()
    {
        $gurus = Guru::with('user')->latest()->paginate(15);
        return view('tu.guru.index', compact('gurus'));
    }

    /**
     * Form tambah guru
     */
    public function guruCreate()
    {
        $jurusan = Jurusan::all();
        return view('tu.guru.create', compact('jurusan'));
    }

    /**
     * Simpan guru (user + guru)
     */
    public function guruStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nik' => 'required|string|max:50|unique:users,nomor_induk',
            'nip' => 'required|string|max:30|unique:gurus,nip',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'email' => 'nullable|email|unique:users,email',
            'telepon' => 'nullable|string|max:30',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();
        try {
            // create user (use NIK as nomor_induk)
            $user = User::create([
                'name' => $request->nama,
                'nomor_induk' => $request->nik,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'guru',
            ]);

            // create guru record
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
            return redirect()->route('tu.guru.index')->with('success', 'Guru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|string|min:8|confirmed',

            // Orang tua
            'nama_ayah'        => 'required|string|max:255',
            'pekerjaan_ayah'   => 'required|string|max:255',
            'telepon_ayah'     => 'nullable|string|max:20',
            'alamat_ayah'      => 'required|string',

            'nama_ibu'         => 'required|string|max:255',
            'pekerjaan_ibu'    => 'required|string|max:255',
            'telepon_ibu'      => 'nullable|string|max:20',
            'alamat_ibu'       => 'required|string',

            // Wali
            'nama_wali'        => 'nullable|string|max:255',
            'alamat_wali'      => 'nullable|string',
            'telepon_wali'     => 'nullable|string|max:20',
            'pekerjaan_wali'   => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Buat user account untuk siswa
            $user = User::create([
                'name' => $request->nama_lengkap,
                'nomor_induk' => $request->nis,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'siswa',
            ]);

            // Simpan data ayah
            $ayah = Ayah::create([
                'nama' => $request->nama_ayah,
                'pekerjaan' => $request->pekerjaan_ayah,
                'telepon' => $request->telepon_ayah,
                'alamat' => $request->alamat_ayah,
            ]);

            // Simpan data ibu
            $ibu = Ibu::create([
                'nama' => $request->nama_ibu,
                'pekerjaan' => $request->pekerjaan_ibu,
                'telepon' => $request->telepon_ibu,
                'alamat' => $request->alamat_ibu,
            ]);

            // Simpan data wali jika ada
            $wali = null;
            if ($request->filled('nama_wali')) {
                $wali = Wali::create([
                    'nama' => $request->nama_wali,
                    'pekerjaan' => $request->pekerjaan_wali,
                    'telepon' => $request->telepon_wali,
                    'alamat' => $request->alamat_wali,
                ]);
            }

            // Simpan data siswa
            $siswa = new DataSiswa();
            $siswa->user_id = $user->id;
            $siswa->nama_lengkap = $request->nama_lengkap;
            $siswa->nis = $request->nis;
            $siswa->nisn = $request->nisn;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->tempat_lahir = $request->tempat_lahir;
            $siswa->tanggal_lahir = $request->tanggal_lahir;
            $siswa->agama = $request->agama;
            $siswa->status_keluarga = $request->status_keluarga;
            $siswa->anak_ke = $request->anak_ke;
            $siswa->alamat = $request->alamat;
            $siswa->no_hp = $request->no_hp;
            $siswa->sekolah_asal = $request->sekolah_asal;
            $siswa->tanggal_diterima = $request->tanggal_diterima;
            $siswa->ayah_id = $ayah->id;
            $siswa->ibu_id = $ibu->id;
            $siswa->wali_id = $wali ? $wali->id : null;
            $siswa->save();

            DB::commit();
            return redirect()->route('tu.siswa')
                ->with('success', 'Data siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Halaman detail siswa
     */
    public function siswaDetail($id)
    {
        $siswa = DataSiswa::with(['user', 'nilaiRaports', 'ayah', 'ibu', 'wali'])->findOrFail($id);
        return view('tu.siswa-detail', compact('siswa'));
    }
    
    /**
     * Halaman edit siswa
     */
    public function siswaEdit($id)
    {
        $siswa = DataSiswa::with(['ayah', 'ibu', 'wali'])->findOrFail($id);
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
            'alamat_ayah'      => 'required|string',

            'nama_ibu'         => 'required|string|max:255',
            'pekerjaan_ibu'    => 'required|string|max:255',
            'telepon_ibu'      => 'nullable|string|max:20',
            'alamat_ibu'       => 'required|string',

            // Wali
            'nama_wali'        => 'nullable|string|max:255',
            'alamat_wali'      => 'nullable|string',
            'telepon_wali'     => 'nullable|string|max:20',
            'pekerjaan_wali'   => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Update data siswa
            $siswa->nama_lengkap = $request->nama_lengkap;
            $siswa->nis = $request->nis;
            $siswa->nisn = $request->nisn;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->tempat_lahir = $request->tempat_lahir;
            $siswa->tanggal_lahir = $request->tanggal_lahir;
            $siswa->agama = $request->agama;
            $siswa->status_keluarga = $request->status_keluarga;
            $siswa->anak_ke = $request->anak_ke;
            $siswa->alamat = $request->alamat;
            $siswa->no_hp = $request->no_hp;
            $siswa->sekolah_asal = $request->sekolah_asal;
            $siswa->tanggal_diterima = $request->tanggal_diterima;
            
            // Update user data
            if ($siswa->user) {
                $siswa->user->name = $request->nama_lengkap;
                $siswa->user->nomor_induk = $request->nis;
                $siswa->user->save();
            }
            
            // Update data ayah
            if ($siswa->ayah_id) {
                $ayah = Ayah::find($siswa->ayah_id);
                $ayah->update([
                    'nama' => $request->nama_ayah,
                    'pekerjaan' => $request->pekerjaan_ayah,
                    'telepon' => $request->telepon_ayah,
                    'alamat' => $request->alamat_ayah,
                ]);
            } else {
                $ayah = Ayah::create([
                    'nama' => $request->nama_ayah,
                    'pekerjaan' => $request->pekerjaan_ayah,
                    'telepon' => $request->telepon_ayah,
                    'alamat' => $request->alamat_ayah,
                ]);
                $siswa->ayah_id = $ayah->id;
            }
            
            // Update data ibu
            if ($siswa->ibu_id) {
                $ibu = Ibu::find($siswa->ibu_id);
                $ibu->update([
                    'nama' => $request->nama_ibu,
                    'pekerjaan' => $request->pekerjaan_ibu,
                    'telepon' => $request->telepon_ibu,
                    'alamat' => $request->alamat_ibu,
                ]);
            } else {
                $ibu = Ibu::create([
                    'nama' => $request->nama_ibu,
                    'pekerjaan' => $request->pekerjaan_ibu,
                    'telepon' => $request->telepon_ibu,
                    'alamat' => $request->alamat_ibu,
                ]);
                $siswa->ibu_id = $ibu->id;
            }
            
            // Update data wali jika ada
            if ($request->filled('nama_wali')) {
                if ($siswa->wali_id) {
                    $wali = Wali::find($siswa->wali_id);
                    $wali->update([
                        'nama' => $request->nama_wali,
                        'pekerjaan' => $request->pekerjaan_wali,
                        'telepon' => $request->telepon_wali,
                        'alamat' => $request->alamat_wali,
                    ]);
                } else {
                    $wali = Wali::create([
                        'nama' => $request->nama_wali,
                        'pekerjaan' => $request->pekerjaan_wali,
                        'telepon' => $request->telepon_wali,
                        'alamat' => $request->alamat_wali,
                    ]);
                    $siswa->wali_id = $wali->id;
                }
            } elseif ($siswa->wali_id) {
                // Hapus data wali jika ada sebelumnya tapi sekarang dikosongkan
                Wali::destroy($siswa->wali_id);
                $siswa->wali_id = null;
            }
            
            $siswa->save();
            DB::commit();
            
            return redirect()->route('tu.siswa.detail', $id)
                ->with('success', 'Data siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Hapus data siswa
     */
    public function siswaDestroy($id)
    {
        $siswa = DataSiswa::findOrFail($id);
        
        DB::beginTransaction();
        try {
            // Hapus data orang tua jika tidak terkait dengan siswa lain
            if ($siswa->ayah_id) {
                $ayahCount = DataSiswa::where('ayah_id', $siswa->ayah_id)->count();
                if ($ayahCount <= 1) {
                    Ayah::destroy($siswa->ayah_id);
                }
            }
            
            if ($siswa->ibu_id) {
                $ibuCount = DataSiswa::where('ibu_id', $siswa->ibu_id)->count();
                if ($ibuCount <= 1) {
                    Ibu::destroy($siswa->ibu_id);
                }
            }
            
            if ($siswa->wali_id) {
                $waliCount = DataSiswa::where('wali_id', $siswa->wali_id)->count();
                if ($waliCount <= 1) {
                    Wali::destroy($siswa->wali_id);
                }
            }
            
            // Hapus user terkait
            if ($siswa->user) {
                $siswa->user->delete();
            }
            
            // Hapus data siswa
            $siswa->delete();
            
            DB::commit();
            return redirect()->route('tu.siswa')
                ->with('success', 'Data siswa berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Halaman daftar kelas
     */
    public function kelas()
    {
        $kelas = Kelas::with(['jurusan', 'rombels', 'waliKelas.user'])->get();
        return view('tu.kelas.index', compact('kelas'));
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
     */
    public function kelasDetail(Request $request, $id)
    {
        $kelas = Kelas::with('jurusan')->findOrFail($id);

        $query = Rombel::with(['siswa' => function($q) {
            $q->with(['ayah', 'ibu', 'wali']);
        }, 'guru'])
        ->where('kelas_id', $id);

        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where('nama', 'like', "%{$q}%");
        }

        // Return all rombels for the kelas (no pagination) so UI can show/ search all
        $rombels = $query->get();

        return view('tu.kelas-detail', compact('kelas', 'rombels'));
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
        $waliKelas = WaliKelas::with(['user', 'rombel.kelas'])
            ->whereHas('user', function ($q) {
                $q->where('role', 'walikelas');
            })
            ->latest()
            ->paginate(10);

        return view('tu.wali-kelas.index', compact('waliKelas'));
    }

    /**
     * Halaman tambah wali kelas
     */
    public function waliKelasCreate()
    {
        $users = User::where('role', 'walikelas')->get();
        $kelas = Kelas::all();
        $jurusans = Jurusan::all();
        $rombels = Rombel::all();
        
        return view('tu.wali-kelas.create', compact('users', 'kelas', 'jurusans', 'rombels'));
    }

    /**
     * Simpan data wali kelas baru
     */
    public function waliKelasStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'jurusan_id' => 'required|exists:jurusans,id',
            'rombel_id' => 'required|exists:rombels,id',
            'tahun_ajaran' => 'required|string|size:9',
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        WaliKelas::create($request->all());
        
        return redirect()->route('tu.wali-kelas')
            ->with('success', 'Data wali kelas berhasil ditambahkan.');
    }

    /**
     * Halaman edit wali kelas
     */
    public function waliKelasEdit($id)
    {
        $waliKelas = WaliKelas::findOrFail($id);
        $users = User::where('role', 'walikelas')->get();
        $kelas = Kelas::all();
        $jurusans = Jurusan::all();
        $rombels = Rombel::all();
        
        return view('tu.wali-kelas.edit', compact('waliKelas', 'users', 'kelas', 'jurusans', 'rombels'));
    }

    /**
     * Update data wali kelas
     */
    public function waliKelasUpdate(Request $request, $id)
    {
        $waliKelas = WaliKelas::findOrFail($id);
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'jurusan_id' => 'required|exists:jurusans,id',
            'rombel_id' => 'required|exists:rombels,id',
            'tahun_ajaran' => 'required|string|size:9',
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $waliKelas->update($request->all());

        return redirect()->route('tu.wali-kelas.detail', $id)
            ->with('success', 'Data wali kelas berhasil diperbarui.');
    }

    /**
     * Hapus data wali kelas
     */
    public function waliKelasDestroy($id)
    {
        $waliKelas = WaliKelas::findOrFail($id);
        $waliKelas->delete();

        return redirect()->route('tu.wali-kelas')
            ->with('success', 'Data wali kelas berhasil dihapus.');
    }
    
    /**
     * Halaman detail wali kelas
     */
    public function waliKelasDetail($id)
    {
        $waliKelas = WaliKelas::with(['user', 'kelas', 'jurusan', 'rombel'])->findOrFail($id);
        
        return view('tu.wali-kelas.show', compact('waliKelas'));
    }
    
    /**
     * Halaman laporan nilai raport
     */
    public function laporanNilai()
    {
        $nilaiRaports = NilaiRaport::with(['siswa' => function($query) {
            $query->with(['ayah', 'ibu', 'wali']);
        }])
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->paginate(20);
            
        return view('tu.laporan-nilai', compact('nilaiRaports'));
    }
}