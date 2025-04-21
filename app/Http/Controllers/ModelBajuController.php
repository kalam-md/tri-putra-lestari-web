<?php

namespace App\Http\Controllers;

use App\Models\BahanBaju;
use App\Models\ModelBaju;
use App\Models\Ukuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $query->with(['ukurans', 'bahanBaju']);

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
            'harga' => 'required|numeric|min:0',
            'keterangan' => 'nullable',
            'ukuran_id' => 'required|array', // Ubah menjadi array
            'ukuran_id.*' => 'exists:ukurans,id', // Validasi setiap ukuran
            'stok' => 'required|array', // Stok untuk setiap ukuran
            'stok.*' => 'required|integer|min:0',
            'bahan_id' => 'required',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Cek stok bahan baju
        $bahanBaju = BahanBaju::findOrFail($request->bahan_id);
        
        // Hitung total stok yang dibutuhkan
        $totalStok = array_sum($request->stok);

        // Validasi jika stok bahan tidak mencukupi
        if ($bahanBaju->stok < $totalStok) {
            alert()->error('Error', 'Stok bahan baju tidak mencukupi');
            return back()->withInput();
        }

        // Proses upload gambar-gambar
        $namaGambars = [];
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $gambar) {
                $namaGambar = uniqid() . '_' . $gambar->getClientOriginalName();
                $gambar->move(public_path() . '/model_baju/', $namaGambar);
                $namaGambars[] = $namaGambar;
            }
        }

        // Mulai transaksi database
        DB::beginTransaction();
        
        try {
            // Buat model baju baru tanpa ukuran
            $modelBaju = ModelBaju::create([
                'nama_model' => $validated['nama_model'],
                'stok' => $totalStok, // Total stok dari semua ukuran
                'harga' => $validated['harga'],
                'keterangan' => $validated['keterangan'] ?? null,
                'bahan_id' => $validated['bahan_id'],
                'gambar' => !empty($namaGambars) ? json_encode($namaGambars) : null,
            ]);
            
            // Hubungkan model baju dengan ukuran yang dipilih dan stok masing-masing
            foreach ($request->ukuran_id as $index => $ukuranId) {
                $modelBaju->ukurans()->attach($ukuranId, [
                    'stok' => $request->stok[$index] ?? 0
                ]);
            }
            
            // Kurangi stok bahan baju
            $bahanBaju->decrement('stok', $totalStok);
            
            DB::commit();
            
            alert()->success('Sukses', 'Model Baju berhasil ditambahkan');
            return redirect()->route('model-baju.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            alert()->error('Error', 'Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ModelBaju $model_baju)
    {
        $model_baju->load(['ukurans', 'bahanBaju']);
        return view('model_baju.show', compact('model_baju'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModelBaju $model_baju)
    {
        $ukurans = Ukuran::all();
        $bahan_bajus = BahanBaju::all();
        $model_baju->load('ukurans');
        
        return view('model_baju.edit', compact('model_baju', 'ukurans', 'bahan_bajus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModelBaju $modelBaju)
    {
        $validated = $request->validate([
            'nama_model' => 'required|max:255',
            'harga' => 'required|numeric|min:0',
            'keterangan' => 'nullable',
            'ukuran_id' => 'required|array', // Ubah menjadi array
            'ukuran_id.*' => 'exists:ukurans,id', // Validasi setiap ukuran
            'stok' => 'required|array', // Stok untuk setiap ukuran
            'stok.*' => 'required|integer|min:0',
            'bahan_id' => 'required',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Ambil data bahan baju lama
        $bahanLama = BahanBaju::findOrFail($modelBaju->bahan_id);
        $stokLama = $modelBaju->stok;
        
        // Ambil data bahan baju baru
        $bahanBaru = BahanBaju::findOrFail($request->bahan_id);
        $stokBaru = array_sum($request->stok);
        
        // Cek ketersediaan stok
        if ($modelBaju->bahan_id != $request->bahan_id) {
            // Jika bahan berbeda
            if ($bahanBaru->stok < $stokBaru) {
                alert()->error('Error', 'Stok bahan baju baru tidak mencukupi');
                return back()->withInput();
            }
        } else {
            // Jika bahan sama tapi stok berubah
            $selisihStok = $stokBaru - $stokLama;
            if ($selisihStok > 0 && $bahanLama->stok < $selisihStok) {
                alert()->error('Error', 'Stok bahan baju tidak mencukupi untuk penambahan');
                return back()->withInput();
            }
        }

        // Mulai transaksi database
        DB::beginTransaction();
        
        try {
            // Proses upload gambar baru jika ada
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($modelBaju->gambar) {
                    $gambarLama = json_decode($modelBaju->gambar);
                    if (is_array($gambarLama)) {
                        foreach ($gambarLama as $gl) {
                            $pathGambar = public_path() . '/model_baju/' . $gl;
                            if (file_exists($pathGambar)) {
                                unlink($pathGambar);
                            }
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
                
                $gambarUpdate = json_encode($namaGambars);
            } else {
                $gambarUpdate = $modelBaju->gambar;
            }

            // Update stok bahan
            if ($modelBaju->bahan_id != $request->bahan_id) {
                // Jika bahan berbeda, kembalikan stok bahan lama dan kurangi stok bahan baru
                $bahanLama->increment('stok', $stokLama);
                $bahanBaru->decrement('stok', $stokBaru);
            } else {
                // Jika bahan sama tapi stok berubah
                $selisihStok = $stokBaru - $stokLama;
                if ($selisihStok > 0) {
                    $bahanLama->decrement('stok', $selisihStok);
                } else if ($selisihStok < 0) {
                    $bahanLama->increment('stok', abs($selisihStok));
                }
            }
            
            // Update model baju
            $modelBaju->update([
                'nama_model' => $validated['nama_model'],
                'stok' => $stokBaru,
                'harga' => $validated['harga'],
                'keterangan' => $validated['keterangan'] ?? null,
                'bahan_id' => $validated['bahan_id'],
                'gambar' => $gambarUpdate,
            ]);
            
            // Sync ukuran dan stok
            $ukuranData = [];
            foreach ($request->ukuran_id as $index => $ukuranId) {
                $ukuranData[$ukuranId] = ['stok' => $request->stok[$index] ?? 0];
            }
            $modelBaju->ukurans()->sync($ukuranData);
            
            DB::commit();
            
            alert()->success('Sukses', 'Model Baju berhasil diperbarui');
            return redirect()->route('model-baju.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->error('Error', 'Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelBaju $modelBaju)
    {
        // Mulai transaksi database
        DB::beginTransaction();
        
        try {
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
            
            // Hapus relasi dengan ukuran (pivot akan otomatis terhapus karena onDelete cascade)
            $modelBaju->ukurans()->detach();
            
            // Hapus model baju
            $modelBaju->delete();
            
            DB::commit();
            
            alert()->success('Sukses', 'Model Baju berhasil dihapus');
            return redirect()->route('model-baju.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->error('Error', 'Terjadi kesalahan: ' . $e->getMessage());
            return back();
        }
    }
}