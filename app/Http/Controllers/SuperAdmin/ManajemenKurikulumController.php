<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use Illuminate\Http\Request;

class ManajemenKurikulumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Kurikulum::withCount('mataPelajarans');

        if ($search) {
            $query->where('nama_kurikulum', 'like', "%{$search}%");
        }

        $kurikulum = $query->orderBy('nama_kurikulum')->paginate(10);

        return view('super_admin.manajemen-kurikulum.index', compact('kurikulum', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super_admin.manajemen-kurikulum.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kurikulum' => 'required|string|max:255|unique:kurikum,nama_kurikulum',
        ]);

        Kurikulum::create($data);

        return redirect()->route('super_admin.manajemen-kurikulum.index')->with('success', 'Kurikulum berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kurikulum = Kurikulum::with('mataPelajarans')->findOrFail($id);
        return view('super_admin.manajemen-kurikulum.show', compact('kurikulum'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        return view('super_admin.manajemen-kurikulum.edit', compact('kurikulum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama_kurikulum' => 'required|string|max:255|unique:kurikum,nama_kurikulum,' . $id,
        ]);

        $kurikulum = Kurikulum::findOrFail($id);
        $kurikulum->update($data);

        return redirect()->route('super_admin.manajemen-kurikulum.index')->with('success', 'Kurikulum berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        $kurikulum->delete();

        return redirect()->route('super_admin.manajemen-kurikulum.index')->with('success', 'Kurikulum berhasil dihapus.');
    }
}