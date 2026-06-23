<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\DataSiswa;
use App\Models\Kkm;
use App\Models\NilaiRaport;
use App\Models\Rombel;
use App\Models\TahunAjaran;
use App\Models\KenaikanKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KenaikanKelasController extends Controller
{
    public function index()
    {
        $tahunAjarans = TahunAjaran::orderBy('tahun', 'desc')->get();
        $rombels = Rombel::with('kelas.jurusan')->orderBy('nama')->get();
        
        return view('kurikulum.kenaikan-kelas.index', compact('tahunAjarans', 'rombels'));
    }

    public function preview(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'semester' => 'required|in:Ganjil,Genap',
            'rombel_id' => 'nullable|exists:rombels,id'
        ]);

        $tahunAjaran = TahunAjaran::find($request->tahun_ajaran_id);
        $semester = $request->semester;
        $rombelId = $request->rombel_id;

        $query = DataSiswa::with(['rombel.kelas', 'nilaiRaports' => function($q) use ($tahunAjaran, $semester) {
            $q->where('tahun_ajaran', $tahunAjaran->tahun)
              ->where('semester', $semester);
        }]);

        if ($rombelId) {
            $query->where('rombel_id', $rombelId);
        }

        $siswas = $query->get();
        
        $results = [];
        foreach ($siswas as $siswa) {
            $naik = $this->checkKenaikan($siswa, $tahunAjaran, $semester);
            $results[] = [
                'siswa' => $siswa,
                'naik' => $naik,
                'alasan' => $this->getAlasan($siswa, $tahunAjaran, $semester)
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $results,
            'total_siswa' => count($results),
            'total_naik' => collect($results)->where('naik', true)->count(),
            'total_tidak_naik' => collect($results)->where('naik', false)->count()
        ]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'semester' => 'required|in:Ganjil,Genap',
            'siswa_ids' => 'required|array',
            'siswa_ids.*' => 'exists:data_siswa,id'
        ]);

        $tahunAjaran = TahunAjaran::find($request->tahun_ajaran_id);
        $semester = $request->semester;
        $userId = Auth::id();

        DB::beginTransaction();
        try {
            foreach ($request->siswa_ids as $siswaId) {
                $siswa = DataSiswa::find($siswaId);
                
                // Cek apakah eligible naik
                $eligible = $this->checkKenaikan($siswa, $tahunAjaran, $semester);
                
                if (!$eligible) {
                    continue;
                }

                // Dapatkan rombel tujuan (kelas berikutnya)
                $rombelTujuan = $this->getRombelTujuan($siswa->rombel);
                
                // Update rombel siswa
                if ($rombelTujuan) {
                    $siswa->rombel_id = $rombelTujuan->id;
                    $siswa->save();
                }

                // Simpan record kenaikan
                KenaikanKelas::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'semester' => $semester,
                        'tahun_ajaran' => $tahunAjaran->tahun,
                    ],
                    [
                        'status' => 'Naik Kelas',
                        'rombel_tujuan_id' => $rombelTujuan ? $rombelTujuan->id : null,
                        'diproses_oleh' => $userId,
                        'tanggal_diproses' => now(),
                        'catatan' => 'Diproses otomatis oleh Kurikulum'
                    ]
                );
            }

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Kenaikan kelas berhasil diproses!'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function checkKenaikan($siswa, $tahunAjaran, $semester)
    {
        // Jika semester Ganjil, tidak naik
        if (strtolower($semester) === 'ganjil') {
            return false;
        }

        // Cek nilai semua mapel
        $nilais = NilaiRaport::where('siswa_id', $siswa->id)
            ->where('tahun_ajaran', $tahunAjaran->tahun)
            ->where('semester', $semester)
            ->get();

        if ($nilais->isEmpty()) {
            return false;
        }

        $kelasId = $siswa->rombel->kelas_id ?? null;

        foreach ($nilais as $nilai) {
            $kkm = Kkm::where('mata_pelajaran_id', $nilai->mata_pelajaran_id)
                ->where('kelas_id', $kelasId)
                ->value('nilai_kkm');

            $kkm = $kkm ?: 75;
            
            if ($nilai->nilai_akhir < $kkm) {
                return false;
            }
        }

        return true;
    }

    private function getAlasan($siswa, $tahunAjaran, $semester)
    {
        if (strtolower($semester) === 'ganjil') {
            return 'Semester ganjil, kenaikan kelas diproses di semester genap';
        }

        $nilais = NilaiRaport::where('siswa_id', $siswa->id)
            ->where('tahun_ajaran', $tahunAjaran->tahun)
            ->where('semester', $semester)
            ->get();

        if ($nilais->isEmpty()) {
            return 'Belum ada nilai rapor';
        }

        $kelasId = $siswa->rombel->kelas_id ?? null;
        $mapelRendah = [];

        foreach ($nilais as $nilai) {
            $kkm = Kkm::where('mata_pelajaran_id', $nilai->mata_pelajaran_id)
                ->where('kelas_id', $kelasId)
                ->value('nilai_kkm');

            $kkm = $kkm ?: 75;
            
            if ($nilai->nilai_akhir < $kkm) {
                $mapel = \App\Models\MataPelajaran::find($nilai->mata_pelajaran_id);
                $mapelRendah[] = ($mapel ? $mapel->nama : 'Mapel') . ' (' . $nilai->nilai_akhir . '/' . $kkm . ')';
            }
        }

        if (count($mapelRendah) > 0) {
            return 'Nilai di bawah KKM pada: ' . implode(', ', array_slice($mapelRendah, 0, 3)) . (count($mapelRendah) > 3 ? ' dan lainnya' : '');
        }

        return 'Memenuhi syarat kenaikan kelas';
    }

    private function getRombelTujuan($rombelSaatIni)
    {
        if (!$rombelSaatIni || !$rombelSaatIni->kelas) {
            return null;
        }

        $kelasSaatIni = $rombelSaatIni->kelas;
        $tingkatSaatIni = $kelasSaatIni->tingkat;
        $jurusanId = $kelasSaatIni->jurusan_id;

        // Mapping tingkat
        $tingkatMap = [
            'X' => 'XI',
            'XI' => 'XII',
            '10' => '11',
            '11' => '12',
            'I' => 'II',
            'II' => 'III'
        ];

        $tingkatTujuan = $tingkatMap[$tingkatSaatIni] ?? null;

        if (!$tingkatTujuan) {
            return null;
        }

        // Cari kelas tujuan
        $kelasTujuan = \App\Models\Kelas::where('tingkat', $tingkatTujuan)
            ->where('jurusan_id', $jurusanId)
            ->first();

        if (!$kelasTujuan) {
            return null;
        }

        // Cari rombel dengan nama yang sama (tanpa tingkat)
        $namaRombelSaatIni = preg_replace('/^(X|XI|XII|10|11|12|I|II|III)\s*/i', '', $rombelSaatIni->nama);
        
        $rombelTujuan = \App\Models\Rombel::where('kelas_id', $kelasTujuan->id)
            ->where('nama', 'like', '%' . $namaRombelSaatIni)
            ->first();

        return $rombelTujuan;
    }
}