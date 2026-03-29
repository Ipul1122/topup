<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Services\MidtransService;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // 1. Menampilkan Halaman Checkout
    public function index(Product $product)
    {
        // Pastikan produk aktif
        if (!$product->is_active) {
            abort(404, 'Produk tidak tersedia');
        }

        return view('checkout', compact('product'));
    }

    // 2. Memproses Data & Meminta Snap Token Midtrans
    public function process(Request $request, MidtransService $midtransService)
    {
        // Validasi input dari user
        $request->validate([
            'product_id'     => 'required|exists:products,id',
            'target_user_id' => 'required|string', // Format: 12345678(1234)
            'customer_name'  => 'required|string',
            'customer_phone' => 'required|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Bikin Order ID unik (Misal: TRX-AB12CD34)
        $orderId = 'TRX-' . strtoupper(Str::random(8));

        // Simpan ke database (Tabel Transactions)
        $transaction = Transaction::create([
            'order_id'       => $orderId,
            'product_id'     => $product->id,
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'target_user_id' => $request->target_user_id,
            'amount'         => $product->price_sell,
            'payment_status' => 'pending',
            'topup_status'   => 'pending',
        ]);

        // Panggil Context Service Midtrans
        $snapToken = $midtransService->createSnapToken([
            'order_id'       => $transaction->order_id,
            'amount'         => $transaction->amount,
            'customer_name'  => $transaction->customer_name,
            'customer_phone' => $transaction->customer_phone,
            'product_sku'    => $product->sku_code,
            'product_name'   => $product->name,
        ]);

        if (!$snapToken) {
            return response()->json(['success' => false, 'message' => 'Gagal mendapatkan token pembayaran'], 500);
        }

        // Kembalikan token ke frontend (AJAX)
        return response()->json(['success' => true, 'snap_token' => $snapToken]);
    }
}