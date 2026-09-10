<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\User;
use App\Exports\GuruTemplateExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GuruController extends Controller
{
    // ==========================================
    // 1. METHOD UNTUK TU KEPEGAWAIAN (MANAJEMEN GURU)
    // ==========================================
    
    public function index(Request $request)
    {
        $query = Guru::query();

        $isFiltered = $request->filled('search') || 
                      $request->filled('status_kepegawaian') || 
                      $request->filled('jenis_kelamin') || 
                      $request->filled('pendidikan');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status_kepegawaian')) {
            $query->where('status_kepegawaian', $request->status_kepegawaian);
        }

        if ($request->filled('jenis_kelamin')) {
            $jk = trim($request->jenis_kelamin);
            $query->where(function($q) use ($jk) {
                if (in_array(strtolower($jk), ['l', 'laki-laki', 'laki'])) {
                    $q->whereIn('jenis_kelamin', ['L', 'l', 'Laki-laki', 'laki-laki', 'Laki', 'laki']);
                } elseif (in_array(strtolower($jk), ['p', 'perempuan'])) {
                    $q->whereIn('jenis_kelamin', ['P', 'p', 'Perempuan', 'perempuan']);
                } else {
                    $q->where('jenis_kelamin', $jk);
                }
            });
        }

        if ($request->filled('pendidikan')) {
            $query->where('pendidikan', $request->pendidikan);
        }

        $allFilteredGurus = (clone $query)->get();
        
        $rekap = [
            'Total'        => $allFilteredGurus->count(),
            'L'            => $allFilteredGurus->filter(function($item) {
                                return in_array(trim($item->jenis_kelamin), ['L', 'l', 'Laki-laki', 'laki-laki', 'Laki', 'laki']);
                            })->count(),
            'P'            => $allFilteredGurus->filter(function($item) {
                                return in_array(trim($item->jenis_kelamin), ['P', 'p', 'Perempuan', 'perempuan']);
                            })->count(),
            'D4'           => $allFilteredGurus->where('pendidikan', 'D4')->count(),
            'S1'           => $allFilteredGurus->where('pendidikan', 'S1')->count(),
            'S2'           => $allFilteredGurus->where('pendidikan', 'S2')->count(),
            'Sertif_Sudah' => $allFilteredGurus->whereNotNull('serdik')->where('serdik', '!=', '')->count(),
        ];

        $perPage = $request->input('per_page', 25);
        
        if ($perPage === 'all') {
            $gurus = $query->get();
        } else {
            $perPage = (int) $perPage;
            if (!in_array($perPage, [10, 25, 50, 100])) {
                $perPage = 25;
            }
            $gurus = $query->paginate($perPage);
            $gurus->appends($request->all());
        }

        return view('tu_kepegawaian.guru.index', [
            'gurus' => $gurus,
            'rekap' => $rekap,
            'isFiltered' => $isFiltered,
            'perPage' => $perPage
        ]);
    }

    public function create()
    {
        return view('tu_kepegawaian.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik'  => 'nullable|string|max:20|unique:gurus,nik',
            'nip'  => 'nullable|string|max:20|unique:gurus,nip',
            'email' => 'nullable|email|unique:gurus,email',
        ]);

        $defaultPassword = '12345678';
        $nomorInduk = $request->nip ?: ($request->nik ?: uniqid());
        
        $existingUser = User::where('nomor_induk', $nomorInduk)->first();
        
        if ($existingUser) {
            $user = $existingUser;
        } else {
            $user = User::create([
                'name'       => $request->nama,
                'nomor_induk'=> $nomorInduk,
                'email'      => $request->email ?? (strtolower(str_replace(' ', '', $request->nama)) . time() . "@smkn1x.sch.id"),
                'password'   => Hash::make($defaultPassword),
                'role'       => 'guru',
            ]);
        }

        $guru = new Guru();
        $guru->nama               = $request->nama;
        $guru->nik                = $request->nik;
        $guru->nuptk              = $request->nuptk;
        $guru->nip                = $request->nip;
        $guru->status_kepegawaian = $request->status_kepegawaian;
        $guru->jenis_kelamin      = $request->jenis_kelamin;
        $guru->pendidikan         = $request->pendidikan;
        $guru->serdik             = $request->serdik;
        $guru->tempat_lahir       = $request->tempat_lahir;
        $guru->tanggal_lahir      = $request->tanggal_lahir;
        $guru->email              = $user->email;
        $guru->email_pribadi      = $request->email_pribadi;
        $guru->email_resmi        = $request->email_resmi;
        $guru->alamat_jalan       = $request->alamat_jalan;
        $guru->alamat             = $request->alamat_jalan ?? $request->alamat;
        $guru->rt                 = $request->rt;
        $guru->rw                 = $request->rw;
        $guru->dusun              = $request->dusun;
        $guru->desa               = $request->desa;
        $guru->kelurahan          = $request->kelurahan ?? $request->desa;
        $guru->kecamatan          = $request->kecamatan;
        $guru->kode_pos           = $request->kode_pos;
        $guru->telepon            = $request->telepon;
        $guru->gelar_depan        = $request->gelar_depan;
        $guru->gelar_belakang     = $request->gelar_belakang;
        $guru->user_id            = $user->id;
        
        $guru->save();

        return redirect()->route('tu_kepegawaian.guru.index')
                         ->with('success', 'Data guru berhasil ditambahkan!');
    }

    public function show($id)
    {
        $guru = Guru::with(['user', 'jurusan', 'rombels.kelas.jurusan'])->findOrFail($id);
        return view('tu_kepegawaian.guru.show', compact('guru'));
    }

    public function edit($id)
    {
        $guru = Guru::with(['user', 'jurusan'])->findOrFail($id);
        return view('tu_kepegawaian.guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        
        // Update data user juga kalau ada perubahan
        if ($guru->user) {
            $userData = [];
            if ($request->filled('nama')) {
                $userData['name'] = $request->nama;
            }
            if ($request->filled('nip')) {
                $userData['nomor_induk'] = $request->nip;
            }
            if ($request->filled('email')) {
                $userData['email'] = $request->email;
            }
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            if (!empty($userData)) {
                $guru->user->update($userData);
            }
        }
        
        $guru->update($request->all());
        
        return redirect()->route('tu_kepegawaian.guru.show', $guru->id)
                       ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        
        if ($guru->user_id) {
            User::where('id', $guru->user_id)->delete();
        }

        $guru->delete();

        return back()->with('success', 'Data guru berhasil dihapus');
    }

    public function template(Request $request)
    {
        $fields = $request->input('fields', [
            'nama', 'nik', 'nuptk', 'nip', 'status_kepegawaian', 
            'jenis_kelamin', 'pendidikan', 'serdik', 'tempat_lahir', 'tanggal_lahir', 
            'email_pribadi', 'email_resmi', 'alamat_jalan', 'rt', 'rw', 'dusun', 'desa', 'kecamatan', 'kode_pos', 'telepon'
        ]);

        return Excel::download(new GuruTemplateExport($fields), 'template_guru.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ], [
            'file.required' => 'Silakan pilih file excel terlebih dahulu.',
            'file.mimes'    => 'Format file harus .xlsx, .xls, atau .csv',
            'file.max'      => 'Ukuran file maksimal 2MB'
        ]);

        try {
            $file = $request->file('file');
            
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $successCount = 0;
            $errors = [];
            $defaultPassword = '12345678';

            foreach ($rows as $index => $row) {
                if ($index === 0) {
                    continue;
                }

                $nama = trim($row[0] ?? '');
                
                if (empty($nama)) {
                    continue;
                }

                $nik            = trim($row[1] ?? null);
                $nuptk          = trim($row[2] ?? null);
                $nip            = trim($row[3] ?? null);
                $status_pegawai = trim($row[4] ?? null);
                $jenis_kelamin  = trim($row[5] ?? 'L');
                $pendidikan     = trim($row[6] ?? null);
                $serdik         = trim($row[7] ?? null);
                $tempat_lahir   = trim($row[8] ?? null);
                $tanggal_lahir  = trim($row[9] ?? null);
                $email_pribadi  = trim($row[10] ?? null);
                $email_resmi    = trim($row[11] ?? null);
                
                $alamat_jalan   = trim($row[12] ?? null);
                $rt             = trim($row[13] ?? null);
                $rw             = trim($row[14] ?? null);
                $dusun          = trim($row[15] ?? null);
                $desa           = trim($row[16] ?? null);
                $kecamatan      = trim($row[17] ?? null);
                $kode_pos       = trim($row[18] ?? null);
                $no_hp          = trim($row[19] ?? null);

                $nomor_induk = $nip ?: ($nik ?: $nama);

                $superAdmin = User::where('nomor_induk', $nomor_induk)->where('role', 'super_admin')->first();
                if ($superAdmin) {
                    $errors[] = "SKIP: Identitas {$nomor_induk} milik SUPER ADMIN.";
                    continue;
                }

                $email = $email_pribadi ?: (strtolower(str_replace(' ', '', $nama)) . time() . "@smkn1x.sch.id");

                $existingUser = User::where('nomor_induk', $nomor_induk)->first();
                if ($existingUser) {
                    if ($existingUser->role === 'super_admin') {
                        continue;
                    }
                    $user = $existingUser;
                    $user->update(['name' => $nama, 'email' => $email]);
                } else {
                    $user = User::create([
                        'name' => $nama,
                        'nomor_induk' => $nomor_induk,
                        'email' => $email,
                        'password' => Hash::make($defaultPassword),
                        'role' => 'guru',
                    ]);
                }

                $guru = Guru::where('nip', $nomor_induk)->orWhere('nik', $nik)->first();
                if (!$guru) {
                    $guru = new Guru();
                }

                $guru->nama                 = $nama;
                $guru->nik                  = $nik;
                $guru->nuptk                = $nuptk;
                $guru->nip                  = $nip ?: $nomor_induk;
                $guru->status_kepegawaian   = $status_pegawai;
                $guru->jenis_kelamin        = $jenis_kelamin;
                $guru->pendidikan           = $pendidikan;
                $guru->serdik               = $serdik;
                $guru->tempat_lahir         = $tempat_lahir;
                $guru->tanggal_lahir        = $tanggal_lahir;
                $guru->email                = $email;
                $guru->email_pribadi        = $email;
                $guru->email_resmi          = $email_resmi;
                
                $guru->alamat_jalan         = $alamat_jalan;
                $guru->alamat               = $alamat_jalan;
                $guru->rt                   = $rt;
                $guru->rw                   = $rw;
                $guru->dusun                = $dusun;
                $guru->desa                 = $desa;
                $guru->kelurahan            = $desa;
                $guru->kecamatan            = $kecamatan;
                $guru->kode_pos             = $kode_pos;
                $guru->telepon              = $no_hp;

                $guru->user_id              = $user->id;
                $guru->save();

                $successCount++;
            }

            if ($successCount === 0) {
                if (count($errors) > 0) {
                    return redirect()->back()
                        ->with('error', 'Gagal mengimport data!')
                        ->with('error_details', $errors);
                }
                return redirect()->back()->with('error', 'Tidak ada data yang diimport.');
            }

            if (count($errors) > 0) {
                return redirect()->back()
                    ->with('success', "Berhasil mengimport {$successCount} data guru.")
                    ->with('error_details', $errors);
            }

            return redirect()->back()->with('success', "Berhasil mengimport {$successCount} data guru!");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimport data: ' . $e->getMessage() . ' (Baris: ' . $e->getLine() . ')');
        }
    }

    // ==========================================
    // 2. METHOD CETAK ABSENSI (FITUR BARU)
    // ==========================================
    public function cetakAbsensi(Request $request)
    {
        // Validasi input
        $request->validate([
            'bulan'    => 'required|integer|min:1|max:12',
            'tahun'    => 'required|integer|min:2000|max:2100',
            'guru_ids' => 'required|array|min:1',
            'guru_ids.*' => 'exists:gurus,id'
        ], [
            'bulan.required' => 'Silakan pilih bulan.',
            'tahun.required' => 'Silakan pilih tahun.',
            'guru_ids.required' => 'Silakan pilih minimal 1 guru.',
            'guru_ids.*.exists' => 'Data guru tidak ditemukan.'
        ]);

        // Ambil data guru
        $gurus = Guru::whereIn('id', $request->guru_ids)
                     ->orderBy('nama', 'asc')
                     ->get();

        // Jika tidak ada guru
        if ($gurus->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data guru yang dipilih.');
        }

        // Format tanggal
        $bulan = (int) $request->bulan;
        $tahun = (int) $request->tahun;
        $tanggalObj = Carbon::createFromDate($tahun, $bulan, 1);
        $hari = strtoupper($tanggalObj->translatedFormat('l'));
        $tanggal = strtoupper($tanggalObj->translatedFormat('j F Y'));

        // Kirim ke view cetak
        return view('tu_kepegawaian.guru.cetak_absensi', compact('gurus', 'tahun', 'hari', 'tanggal'));
    }

    // ==========================================
    // 3. METHOD UNTUK WALI KELAS (PROFILE)
    // ==========================================
    public function profileShow()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();
        return view('walikelas.profile', compact('guru'));
    }

    public function profileEdit()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();
        return view('walikelas.profile_edit', compact('guru'));
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();
        $guru->update($request->all());
        return redirect()->route('walikelas.data_diri.profile')
                         ->with('success', 'Profile berhasil diupdate.');
    }

    // ==========================================
    // 4. METHOD HELPER
    // ==========================================
    public function getGuruByUserId($userId)
    {
        return Guru::where('user_id', $userId)->first();
    }
}