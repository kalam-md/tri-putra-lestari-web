<?php

namespace App\Http\Controllers;

use App\Models\KeranjangItem;
use App\Models\ModelBaju;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        // Get the current user's cart items
        $keranjangItems = KeranjangItem::with(['modelBaju', 'ukuran'])
            ->where('user_id', auth()->id())
            ->get();
            
        $totalHarga = $keranjangItems->sum(function($item) {
            return $item->jumlah * $item->modelBaju->harga;
        });
        
        return view('keranjang.index', compact('keranjangItems', 'totalHarga'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'model_baju_id' => 'required|exists:model_bajus,id',
            'ukuran_id' => 'required|exists:ukurans,id',
            'jumlah' => 'required|integer|min:1'
        ]);
        
        $modelBaju = ModelBaju::findOrFail($validated['model_baju_id']);
        
        // Check if ukuran exists for this model and has enough stock
        $ukuran = $modelBaju->ukurans()->where('ukuran_id', $validated['ukuran_id'])->first();
        
        if (!$ukuran || $ukuran->pivot->stok < $validated['jumlah']) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }
        
        // Check if item already exists in cart
        $existingItem = KeranjangItem::where('user_id', auth()->id())
            ->where('model_baju_id', $validated['model_baju_id'])
            ->where('ukuran_id', $validated['ukuran_id'])
            ->first();
            
        if ($existingItem) {
            // Check if new total quantity exceeds available stock
            if (($existingItem->jumlah + $validated['jumlah']) > $ukuran->pivot->stok) {
                return redirect()->back()->with('error', 'Total jumlah melebihi stok yang tersedia!');
            }
            
            // Update quantity if item exists
            $existingItem->jumlah += $validated['jumlah'];
            $existingItem->save();
        } else {
            // Create new cart item
            KeranjangItem::create([
                'user_id' => auth()->id(),
                'model_baju_id' => $validated['model_baju_id'],
                'ukuran_id' => $validated['ukuran_id'],
                'jumlah' => $validated['jumlah']
            ]);
        }
        
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
    
    public function update(Request $request, KeranjangItem $keranjangItem)
    {
        $validated = $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);
        
        // Make sure the cart item belongs to the current user
        if ($keranjangItem->user_id !== auth()->id()) {
            return redirect()->route('keranjang.index')->with('error', 'Item tidak ditemukan!');
        }
        
        $modelBaju = ModelBaju::findOrFail($keranjangItem->model_baju_id);
        $ukuran = $modelBaju->ukurans()->where('ukuran_id', $keranjangItem->ukuran_id)->first();
        
        // Check if requested quantity exceeds available stock
        if (!$ukuran || $validated['jumlah'] > $ukuran->pivot->stok) {
            return redirect()->route('keranjang.index')->with('error', 'Jumlah melebihi stok yang tersedia!');
        }
        
        $keranjangItem->jumlah = $validated['jumlah'];
        $keranjangItem->save();
        
        return redirect()->route('keranjang.index')->with('success', 'Keranjang berhasil diperbarui!');
    }
    
    public function destroy(KeranjangItem $keranjangItem)
    {
        // Make sure the cart item belongs to the current user
        if ($keranjangItem->user_id !== auth()->id()) {
            return redirect()->route('keranjang.index')->with('error', 'Item tidak ditemukan!');
        }
        
        $keranjangItem->delete();
        
        return redirect()->route('keranjang.index')->with('success', 'Item berhasil dihapus dari keranjang!');
    }
}