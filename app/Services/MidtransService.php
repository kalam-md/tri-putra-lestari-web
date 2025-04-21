<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Order;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function createTransaction(Order $order)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $order->kode_order,
                'gross_amount' => $order->total_harga,
            ],
            'customer_details' => [
                'first_name' => $order->nama_penerima,
                'phone' => $order->no_telepon,
            ],
            'item_details' => $order->items->map(function($item) {
                return [
                    'id' => $item->model_baju_id,
                    'price' => $item->harga,
                    'quantity' => $item->jumlah,
                    'name' => $item->modelBaju->nama_model . ' (Ukuran: ' . $item->ukuran->ukuran_baju . ')',
                ];
            })->toArray(),
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }

    public function getSnapUrl(Order $order)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $order->kode_order,
                'gross_amount' => $order->total_harga,
            ],
            'customer_details' => [
                'first_name' => $order->nama_penerima,
                'phone' => $order->no_telepon,
            ],
            'item_details' => $order->items->map(function($item) {
                return [
                    'id' => $item->model_baju_id,
                    'price' => $item->harga,
                    'quantity' => $item->jumlah,
                    'name' => $item->modelBaju->nama_model . ' (Ukuran: ' . $item->ukuran->ukuran_baju . ')',
                ];
            })->toArray(),
        ];

        $snapUrl = Snap::createTransaction($params)->redirect_url;

        return $snapUrl;
    }
}