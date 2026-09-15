<?php

namespace App\Http\Controllers\Kurikulum;

use App\Http\Controllers\Controller;
use App\Models\Rombel;
use App\Models\Guru;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WaliKelasMappingController extends Controller
{
    /**
     * Menampilkan halaman mapping wali kelas
     */
   public function index(Request $request)
{
    // Ambil filter dari request
    $jurusan_id = $request->query('jurusan', '');
    $status_filter = $request->query('status', '');
    $search = $request->query('search', '');
    
    // Ambil semua jurusan untuk filter
    $allJurusans = Jurusan::orderBy('nama')->get();
    
    // Query rombel dengan relasi
    $query = Rombel::with(['kelas.jurusan', 'guru', 'siswa'])
        ->whereHas('kelas', function($q) {
            $q->whereIn('tingkat', ['X', 'XI', 'XII']);
        })
        ->orderBy('kelas_id')
        ->orderBy('nama');
        
    // Filter by jurusan
    if (!empty($jurusan_id)) {
        $query->whereHas('kelas', function($q) use ($jurusan_id) {
            $q->where('jurusan_id', $jurusan_id);
        });
    }
    
    // Filter by status
    if ($status_filter === 'sudah') {
        $query->whereNotNull('guru_id');
    } elseif ($status_filter === 'belum') {
        $query->whereNull('guru_id');
    }
    
    // Filter by search (nama rombel)
    if (!empty($search)) {
        $query->where('nama', 'like', "%{$search}%");
    }
    
    $rombels = $query->paginate(20)->withQueryString();
    
    // ============================================================
    // AMBIL SEMUA GURU UNTUK DROPDOWN — PAKAI NIP SEBAGAI LABEL
    // ============================================================
    $allGurus = Guru::with('user')
        ->orderBy('nama')
        ->get()
        ->mapWithKeys(function($guru) {
            // Tampilkan: Nama - NIP - Role
            $label = $guru->nama;
            
            if (!empty($guru->nip)) {
                $label .= ' - ' . $guru->nip;
            }
            
            if ($guru->user) {
                $label .= ' (' . ucfirst(str_replace('_', ' ', $guru->user->role)) . ')';
            }
            
            return [
                $guru->id => $label
            ];
        });
        
    // Statistik untuk widget
    $statistics = [
        'total_rombels' => Rombel::count(),
        'total_wali_kelas' => Rombel::whereNotNull('guru_id')->count(),
        'belum_wali_kelas' => Rombel::whereNull('guru_id')->count(),
    ];
    
    return view('kurikulum.wali-kelas-mapping.index', compact(
        'rombels', 
        'allGurus', 
        'allJurusans', 
        'jurusan_id',
        'status_filter',
        'search',
        'statistics'
    ));
}
    
    /**
     * Update wali kelas untuk satu rombel
     */
    public function update(Request $request)
    {
        $request->validate([
            'rombel_id' => 'required|exists:rombels,id',
            'guru_id' => 'nullable|exists:gurus,id',
        ]);
        
        try {
            DB::beginTransaction();
            
            $rombel = Rombel::findOrFail($request->rombel_id);
            
            // Jika guru_id null, berarti hapus wali kelas
            if (empty($request->guru_id)) {
                // Hapus relasi di guru
                if ($rombel->guru_id) {
                    $oldGuru = Guru::find($rombel->guru_id);
                    if ($oldGuru) {
                        $oldGuru->rombel_id = null;
                        $oldGuru->save();
                    }
                }
                
                $rombel->guru_id = null;
                $rombel->save();
                
                DB::commit();
                return redirect()->back()
                    ->with('success', 'Wali kelas berhasil dihapus dari ' . $rombel->display_name);
            }
            
            // Cek apakah guru sudah menjadi wali kelas di rombel lain
            $existing = Rombel::where('guru_id', $request->guru_id)
                ->where('id', '!=', $request->rombel_id)
                ->first();
                
            if ($existing) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Guru ini sudah menjadi wali kelas di ' . $existing->display_name);
            }
            
            // Update rombel
            $rombel->guru_id = $request->guru_id;
            $rombel->save();
            
            // Update guru's rombel_id (sync balik)
            $guru = Guru::find($request->guru_id);
            if ($guru) {
                $guru->rombel_id = $rombel->id;
                $guru->save();
            }
            
            DB::commit();
            
            return redirect()->back()
                ->with('success', 'Wali kelas berhasil diupdate untuk ' . $rombel->display_name);
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating wali kelas: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Update massal wali kelas
     */
    public function updateMassal(Request $request)
    {
        $request->validate([
            'rombel_ids' => 'required|array',
            'rombel_ids.*' => 'exists:rombels,id',
            'guru_id' => 'required|exists:gurus,id',
        ]);
        
        try {
            DB::beginTransaction();
            
            $guru = Guru::find($request->guru_id);
            
            // Cek apakah guru sudah menjadi wali kelas di rombel lain
            $existingRombels = Rombel::where('guru_id', $guru->id)
                ->whereNotIn('id', $request->rombel_ids)
                ->get();
                
            if ($existingRombels->count() > 0) {
                $rombelNames = $existingRombels->pluck('display_name')->join(', ');
                DB::rollBack();
                return redirect()->back()
                    ->with('error', "Guru ini sudah menjadi wali kelas di: {$rombelNames}");
            }
            
            // Update semua rombel
            foreach ($request->rombel_ids as $rombel_id) {
                $rombel = Rombel::find($rombel_id);
                if ($rombel) {
                    $rombel->guru_id = $guru->id;
                    $rombel->save();
                }
            }
            
            // Update guru's rombel_id ke rombel terakhir
            if ($guru) {
                $lastRombel = Rombel::where('guru_id', $guru->id)->latest()->first();
                if ($lastRombel) {
                    $guru->rombel_id = $lastRombel->id;
                    $guru->save();
                }
            }
            
            DB::commit();
            
            return redirect()->back()
                ->with('success', 'Wali kelas berhasil diupdate massal untuk ' . count($request->rombel_ids) . ' rombel');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error massal updating wali kelas: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}