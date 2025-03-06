<?php

namespace App\Http\Controllers;

use App\Models\Ukuran;
use Illuminate\Http\Request;

class UkuranController extends Controller
{
    public function index(Request $request)
    {
        $query = Ukuran::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('ukuran_baju', 'LIKE', "%{$search}%");
        }

        $ukurans = $query->paginate(5);
        return view('ukuran.index', compact('ukurans'));
    }

    public function create()
    {
        return view('ukuran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ukuran_baju' => 'required|unique:ukurans|max:10',
            'panjang_badan' => 'required|integer|min:0',
            'panjang_tangan' => 'required|integer|min:0',
            'lebar_dada' => 'required|integer|min:0'
        ]);

        Ukuran::create($validated);

        alert()->success('Sukses', 'Ukuran berhasil ditambahkan');
        return redirect()->route('ukuran.index');
    }

    public function edit(Ukuran $ukuran)
    {
        return view('ukuran.edit', compact('ukuran'));
    }
   
    public function update(Request $request, Ukuran $ukuran)
    {
        $validated = $request->validate([
            'ukuran_baju' => 'required|max:10|unique:ukurans,ukuran_baju,'.$ukuran->id,
            'panjang_badan' => 'required|integer|min:0',
            'panjang_tangan' => 'required|integer|min:0',
            'lebar_dada' => 'required|integer|min:0'
        ]);

        $ukuran->update($validated);

        alert()->success('Sukses', 'Ukuran berhasil diperbarui');
        return redirect()->route('ukuran.index');
    }

    public function destroy(Ukuran $ukuran)
    {
        $ukuran->delete();

        alert()->success('Sukses', 'Ukuran berhasil dihapus');
        return redirect()->route('ukuran.index');
    }
}
