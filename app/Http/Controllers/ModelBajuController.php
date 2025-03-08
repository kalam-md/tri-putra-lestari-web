<?php

namespace App\Http\Controllers;

use App\Models\BahanBaju;
use App\Models\ModelBaju;
use App\Models\Ukuran;
use Illuminate\Http\Request;

class ModelBajuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ModelBaju::query();

        // Fitur pencarian
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nama_model', 'LIKE', "%{$search}%");
            });
        }

        // Include relations
        $query->with(['ukuran', 'bahanBaju']);

        // Pagination
        $model_bajus = $query->paginate(5);

        return view('model_baju.index', compact('model_bajus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ukurans = Ukuran::all();
        $bahan_bajus = BahanBaju::all();
        
        return view('model_baju.create', compact('ukurans', 'bahan_bajus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_model' => 'required|max:255',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'keterangan' => 'nullable',
            'ukuran_id' => 'required',
            'bahan_id' => 'required',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Cek stok bahan baju
        $bahanBaju = BahanBaju::findOrFail($request->bahan_id);

        // Validasi jika stok bahan tidak mencukupi
        if ($bahanBaju->stok < $request->stok) {
            alert()->error('Error', 'Stok bahan baju tidak mencukupi');
            return back()->withInput();
        }

        // Proses upload gambar-gambar
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $gambar) {
                $namaGambar = uniqid() . '_' . $gambar->getClientOriginalName();
                $gambar->move(public_path() . '/model_baju/', $namaGambar);
                $namaGambars[] = $namaGambar;
            }
        }

        $validated['gambar'] = json_encode($namaGambars);

        ModelBaju::create($validated);

        // Kurangi stok bahan baju
        $bahanBaju->decrement('stok', $request->stok);

        alert()->success('Sukses', 'Model Baju berhasil ditambahkan');
        return redirect()->route('model-baju.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ModelBaju $model_baju)
    {
        $model_baju->load(['ukuran', 'bahanBaju']);
        return view('model_baju.show', compact('model_baju'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModelBaju $model_baju)
    {
        $ukurans = Ukuran::all();
        $bahan_bajus = BahanBaju::all();
        
        return view('model_baju.edit', compact('model_baju', 'ukurans', 'bahan_bajus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModelBaju $modelBaju)
    {
        $validated = $request->validate([
            'nama_model' => 'required|max:255',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'keterangan' => 'nullable',
            'ukuran_id' => 'required',
            'bahan_id' => 'required',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Ambil data bahan baju lama
        $bahanLama = BahanBaju::findOrFail($modelBaju->bahan_id);
        $stokLama = $modelBaju->stok;
        
        // Ambil data bahan baju baru
        $bahanBaru = BahanBaju::findOrFail($request->bahan_id);
        $stokBaru = $request->stok;
        
        // Jika bahan berbeda
        if ($modelBaju->bahan_id != $request->bahan_id) {
            // Kembalikan stok bahan lama
            $bahanLama->increment('stok', $stokLama);
            
            // Cek apakah stok bahan baru mencukupi
            if ($bahanBaru->stok < $stokBaru) {
                alert()->error('Error', 'Stok bahan baju baru tidak mencukupi');
                return back()->withInput();
            }
            
            // Kurangi stok bahan baru
            $bahanBaru->decrement('stok', $stokBaru);
        } 
        // Jika bahan sama tapi stok berubah
        else if ($stokLama != $stokBaru) {
            $selisihStok = $stokBaru - $stokLama;
            
            // Jika stok baru lebih banyak, kurangi stok bahan
            if ($selisihStok > 0) {
                // Cek apakah stok bahan mencukupi untuk penambahan
                if ($bahanLama->stok < $selisihStok) {
                    alert()->error('Error', 'Stok bahan baju tidak mencukupi untuk penambahan');
                    return back()->withInput();
                }
                
                $bahanLama->decrement('stok', $selisihStok);
            } 
            // Jika stok baru lebih sedikit, kembalikan stok bahan
            else if ($selisihStok < 0) {
                $bahanLama->increment('stok', abs($selisihStok));
            }
        }

        // Proses upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($modelBaju->gambar) {
                $gambarLama = json_decode($modelBaju->gambar);
                foreach ($gambarLama as $gl) {
                    if (file_exists(public_path() . '/model_baju/' . $gl)) {
                        unlink(public_path() . '/model_baju/' . $gl);
                    }
                }
            }
            
            // Upload gambar baru
            $namaGambars = [];
            foreach ($request->file('gambar') as $gambar) {
                $namaGambar = uniqid() . '_' . $gambar->getClientOriginalName();
                $gambar->move(public_path() . '/model_baju/', $namaGambar);
                $namaGambars[] = $namaGambar;
            }
            
            $validated['gambar'] = json_encode($namaGambars);
        }

        // Update model baju
        $modelBaju->update($validated);

        alert()->success('Sukses', 'Model Baju berhasil diperbarui');
        return redirect()->route('model-baju.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelBaju $modelBaju)
    {
        // Ambil data bahan baju
        $bahanBaju = BahanBaju::findOrFail($modelBaju->bahan_id);
        
        // Kembalikan stok bahan baju
        $bahanBaju->increment('stok', $modelBaju->stok);
        
        // Hapus gambar dari storage jika ada
        if ($modelBaju->gambar) {
            $gambarArray = json_decode($modelBaju->gambar);
            if (is_array($gambarArray)) {
                foreach ($gambarArray as $gambar) {
                    $pathGambar = public_path() . '/model_baju/' . $gambar;
                    if (file_exists($pathGambar)) {
                        unlink($pathGambar);
                    }
                }
            }
        }
        
        // Hapus model baju
        $modelBaju->delete();
        
        alert()->success('Sukses', 'Model Baju berhasil dihapus');
        return redirect()->route('model-baju.index');
    }
}
