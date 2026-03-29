<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function __construct()
    {
        // Set konfigurasi Midtrans dari file config/midtrans.php
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production'); // false = Sandbox
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Membuat Transaksi Midtrans dan mengembalikan Snap Token / Redirect URL
     */
    public function createSnapToken(array $transactionData): ?string
    {
        $params = [
            'transaction_details' => [
                'order_id'     => $transactionData['order_id'],
                'gross_amount' => (int) $transactionData['amount'],
            ],
            'customer_details' => [
                'first_name' => $transactionData['customer_name'],
                'phone'      => $transactionData['customer_phone'],
            ],
            'item_details' => [
                [
                    'id'       => $transactionData['product_sku'],
                    'price'    => (int) $transactionData['amount'],
                    'quantity' => 1,
                    'name'     => $transactionData['product_name'],
                ]
            ],
        ];

        try {
            // Minta Snap Token ke Midtrans
            $snapToken = Snap::getSnapToken($params);
            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Midtrans Create Token Error: ' . $e->getMessage());
            return null;
        }
    }
}