<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.modelBaju', 'items.ukuran'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('orders.index', compact('orders'));
    }
    
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        $order->load(['items.modelBaju', 'items.ukuran']);
        
        return view('orders.show', compact('order'));
    }
    
    public function payment(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        if ($order->status !== 'menunggu_pembayaran' || empty($order->payment_url)) {
            return redirect()->route('orders.show', $order);
        }
        
        return view('orders.payment', compact('order'));
    }
}
