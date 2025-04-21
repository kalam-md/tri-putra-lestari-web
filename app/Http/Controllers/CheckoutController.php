<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\KeranjangItem;
use App\Models\ModelBaju;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $keranjangItems = KeranjangItem::with(['modelBaju', 'ukuran'])
            ->where('user_id', auth()->id())
            ->get();
            
        if ($keranjangItems->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang belanja Anda kosong!');
        }
        
        $totalHarga = $keranjangItems->sum(function($item) {
            return $item->jumlah * $item->modelBaju->harga;
        });
        
        return view('checkout.index', compact('keranjangItems', 'totalHarga'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'kode_pos' => 'required|string|max:10',
            'catatan' => 'nullable|string',
            'metode_pembayaran' => 'required|string|in:transfer_bank,cod,e-wallet'
        ]);
        
        $keranjangItems = KeranjangItem::with(['modelBaju', 'ukuran'])
            ->where('user_id', auth()->id())
            ->get();
            
        if ($keranjangItems->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang belanja Anda kosong!');
        }
        
        $totalHarga = $keranjangItems->sum(function($item) {
            return $item->jumlah * $item->modelBaju->harga;
        });
        
        DB::beginTransaction();
        
        try {
            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_harga' => $totalHarga,
                'status' => 'menunggu_pembayaran',
                'nama_penerima' => $validated['nama_penerima'],
                'no_telepon' => $validated['no_telepon'],
                'alamat' => $validated['alamat'],
                'kode_pos' => $validated['kode_pos'],
                'catatan' => $validated['catatan'] ?? null,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'kode_order' => 'ORD-' . time() . auth()->id()
            ]);
            
            // Create order items and reduce stock
            foreach ($keranjangItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'model_baju_id' => $item->model_baju_id,
                    'ukuran_id' => $item->ukuran_id,
                    'jumlah' => $item->jumlah,
                    'harga' => $item->modelBaju->harga,
                    'subtotal' => $item->jumlah * $item->modelBaju->harga
                ]);
                
                // Update stock
                $modelBaju = $item->modelBaju;
                $ukuran = $modelBaju->ukurans()->where('ukuran_id', $item->ukuran_id)->first();
                
                // Reduce stock in pivot table
                $newStock = $ukuran->pivot->stok - $item->jumlah;
                $modelBaju->ukurans()->updateExistingPivot($item->ukuran_id, ['stok' => $newStock]);
                
                // Update total stock in model_bajus table
                $modelBaju->stok = $modelBaju->ukurans()->sum('model_baju_ukuran.stok');
                $modelBaju->save();
            }
            
            // Generate Midtrans payment
            if ($validated['metode_pembayaran'] !== 'cod') {
                $midtransService = new MidtransService();
                $snapToken = $midtransService->createTransaction($order);
                $snapUrl = $midtransService->getSnapUrl($order);
                
                $order->update([
                    'snap_token' => $snapToken,
                    'payment_url' => $snapUrl
                ]);
            }
            
            // Clear the cart
            KeranjangItem::where('user_id', auth()->id())->delete();
            
            DB::commit();
            
            if ($validated['metode_pembayaran'] === 'cod') {
                return redirect()->route('orders.show', $order)->with('success', 'Pesanan COD berhasil dibuat!');
            } else {
                return redirect($snapUrl);
            }
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('checkout.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}