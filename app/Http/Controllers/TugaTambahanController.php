<?php

namespace App\Http\Controllers;

use App\Models\TugasTambahan;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugaTambahanController extends Controller
{
    /**
     * Display a listing of tugas tambahan
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Check if user is TU (Tata Usaha) - based on role check in controller
        // This assumes there's a role system; adjust as needed
        
        $search = $request->query('search', '');
        $filterTipe = $request->query('tipe', '');
        
        $query = TugasTambahan::with('guru.user');
        
        // Search by guru name or NIP
        if ($search) {
            $query->whereHas('guru.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nomor_induk', 'like', "%{$search}%");
            })->orWhereHas('guru', function ($q) use ($search) {
                $q->where('nip', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }
        
        // Filter by tipe tugas
        if ($filterTipe) {
            $query->where('tipe_tugas', $filterTipe);
        }
        
        $tugasTambahans = $query->orderBy('created_at', 'desc')->paginate(15);
        $tipeOptions = TugasTambahan::getAvailableTipes();
        
        return view('tu_kepegawaian.tugas_tambahan.index', compact('tugasTambahans', 'search', 'filterTipe', 'tipeOptions'));
    }

    /**
     * Show the form for creating a new tugas tambahan
     */
    public function create()
    {
        $gurus = Guru::with('user')->orderBy('nama')->get();
        $tipeOptions = TugasTambahan::getAvailableTipes();
        
        // Tambahkan data guru dengan role untuk auto-fill
        $guruData = $gurus->map(function($guru) {
            return [
                'id' => $guru->id,
                'nama' => $guru->nama,
                'nip' => $guru->nip,
                'role' => $guru->user?->role
            ];
        });
        
        return view('tu_kepegawaian.tugas_tambahan.create', compact('gurus', 'tipeOptions', 'guruData'));
    }

    /**
     * Store a newly created tugas tambahan in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'tipe_tugas' => 'nullable|in:wali_kelas,waka_kesiswaan,kaprog',
            'tahun_ajaran' => 'nullable|string|max:50',
        ]);
        
        // Auto-fill tipe_tugas dari role guru jika tidak dipilih
        if (empty($validated['tipe_tugas'])) {
            $guru = Guru::with('user')->findOrFail($validated['guru_id']);
            $validated['tipe_tugas'] = $guru->user?->role;
            
            if (empty($validated['tipe_tugas'])) {
                return redirect()->back()
                    ->withErrors(['tipe_tugas' => 'Guru ini belum memiliki role yang valid. Silakan pilih tipe tugas secara manual.'])
                    ->withInput();
            }
        }

        // Check if this teacher already has this type of task
        $existing = TugasTambahan::where('guru_id', $validated['guru_id'])
            ->where('tipe_tugas', $validated['tipe_tugas'])
            ->first();

        if ($existing) {
            return redirect()->back()->withErrors([
                'guru_id' => 'Guru ini sudah memiliki tugas tambahan dengan tipe yang sama.'
            ])->withInput();
        }

        TugasTambahan::create($validated);

        return redirect()->route('tu_kepegawaian.tugas_tambahan.index')
            ->with('success', 'Tugas tambahan berhasil ditambahkan.');
    }

    /**
     * Display the specified tugas tambahan
     */
    public function show($id)
    {
        $tugasTambahan = TugasTambahan::with('guru.user')->findOrFail($id);
        
        return view('tu_kepegawaian.tugas_tambahan.show', compact('tugasTambahan'));
    }

    /**
     * Show the form for editing the specified tugas tambahan
     */
    public function edit($id)
    {
        $tugasTambahan = TugasTambahan::findOrFail($id);
        $gurus = Guru::with('user')->orderBy('nama')->get();
        $tipeOptions = TugasTambahan::getAvailableTipes();
        
        // Tambahkan data guru dengan role untuk auto-fill
        $guruData = $gurus->map(function($guru) {
            return [
                'id' => $guru->id,
                'nama' => $guru->nama,
                'nip' => $guru->nip,
                'role' => $guru->user?->role
            ];
        });
        
        return view('tu_kepegawaian.tugas_tambahan.edit', compact('tugasTambahan', 'gurus', 'tipeOptions', 'guruData'));
    }

    /**
     * Update the specified tugas tambahan in storage
     */
    public function update(Request $request, $id)
    {
        $tugasTambahan = TugasTambahan::findOrFail($id);

        $validated = $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'tipe_tugas' => 'required|in:wali_kelas,waka_kesiswaan,kaprog',
            'tahun_ajaran' => 'nullable|string|max:50',
        ]);

        // Check if another teacher already has this type of task (if guru_id changed)
        if ($tugasTambahan->guru_id != $validated['guru_id']) {
            $existing = TugasTambahan::where('guru_id', $validated['guru_id'])
                ->where('tipe_tugas', $validated['tipe_tugas'])
                ->first();

            if ($existing) {
                return redirect()->back()->withErrors([
                    'guru_id' => 'Guru ini sudah memiliki tugas tambahan dengan tipe yang sama.'
                ])->withInput();
            }
        }

        $tugasTambahan->update($validated);

        return redirect()->route('tu_kepegawaian.tugas_tambahan.index')
            ->with('success', 'Tugas tambahan berhasil diperbarui.');
    }

    /**
     * Remove the specified tugas tambahan from storage
     */
    public function destroy($id)
    {
        $tugasTambahan = TugasTambahan::findOrFail($id);
        $tugasTambahan->delete();

        return redirect()->route('tu_kepegawaian.tugas_tambahan.index')
            ->with('success', 'Tugas tambahan berhasil dihapus.');
    }
}
