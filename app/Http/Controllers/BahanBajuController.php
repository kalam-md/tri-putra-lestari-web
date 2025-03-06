<?php

namespace App\Http\Controllers;

use App\Models\BahanBaju;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BahanBajuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BahanBaju::query();

        // Fitur pencarian
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nama_bahan', 'LIKE', "%{$search}%")
                  ->orWhere('motif_bahan', 'LIKE', "%{$search}%");
            });
        }

        // Pagination
        $bahan_bajus = $query->paginate(5);

        return view('bahan_baju.index', compact('bahan_bajus'));
    }

    public function create()
    {
        return view('bahan_baju.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bahan' => 'required|max:255',
            'motif_bahan' => 'required|max:255',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|max:2048' // Maks 2MB
        ]);

        // Proses upload gambar
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('bahan_baju', 'public');
            $validated['gambar'] = basename($gambarPath);
        }

        BahanBaju::create($validated);

        alert()->success('Sukses', 'Bahan Baju berhasil ditambahkan');
        return redirect()->route('bahan-baju.index');
    }

    public function edit(BahanBaju $bahan_baju)
    {
        return view('bahan_baju.edit', compact('bahan_baju'));
    }

    public function update(Request $request, BahanBaju $bahan_baju)
    {
        $validated = $request->validate([
            'nama_bahan' => 'required|max:255',
            'motif_bahan' => 'required|max:255',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|max:2048'
        ]);

        // Proses upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($bahan_baju->gambar) {
                Storage::disk('public')->delete('bahan_baju/' . $bahan_baju->gambar);
            }

            $gambarPath = $request->file('gambar')->store('bahan_baju', 'public');
            $validated['gambar'] = basename($gambarPath);
        }

        $bahan_baju->update($validated);

        alert()->success('Sukses', 'Bahan Baju berhasil diperbarui');
        return redirect()->route('bahan-baju.index');
    }

    public function destroy(BahanBaju $bahan_baju)
    {
        // Hapus gambar jika ada
        if ($bahan_baju->gambar) {
            Storage::disk('public')->delete('bahan_baju/' . $bahan_baju->gambar);
        }

        $bahan_baju->delete();

        alert()->success('Sukses', 'Bahan Baju berhasil dihapus');
        return redirect()->route('bahan-baju.index');
    }

    public function show(BahanBaju $bahan_baju)
    {
        return view('bahan_baju.show', compact('bahan_baju'));
    }
}
