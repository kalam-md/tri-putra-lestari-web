<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\MidtransService;

class PaymentController extends Controller
{
    public function notification(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);
        
        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.server_key'));
        
        if ($notification->signature_key != $validSignatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }
        
        $order = Order::where('kode_order', $notification->order_id)->first();
        
        if (!$order) {
            return response(['message' => 'Order not found'], 404);
        }
        
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;
        
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $order->status = 'menunggu_pembayaran';
            } else if ($fraudStatus == 'accept') {
                $order->status = 'diproses';
            }
        } else if ($transactionStatus == 'settlement') {
            $order->status = 'diproses';
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $order->status = 'dibatalkan';
        } else if ($transactionStatus == 'pending') {
            $order->status = 'menunggu_pembayaran';
        }
        
        $order->save();
        
        return response(['message' => 'Notification processed'], 200);
    }
}
