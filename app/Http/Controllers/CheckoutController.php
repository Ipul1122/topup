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
        // 1. Validasi Input
        $request->validate([
            'product_id'     => 'required|exists:products,id',
            'target_user_id' => 'required|string', 
            'customer_phone' => 'required|string',
            'customer_email' => 'required|email', // Validasi email dari frontend
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // 2. Kalkulasi Total + PPN (Keamanan Backend)
        $ppn = $product->price_sell * 0.11;
        $totalAmount = round($product->price_sell + $ppn); // Dibulatkan agar tidak ada desimal aneh

        $orderId = 'TRX-' . strtoupper(Str::random(8));

        // 3. Simpan ke database
        // Kita simpan email di kolom customer_name karena tabel lu belum punya kolom khusus email
        $transaction = Transaction::create([
            'order_id'       => $orderId,
            'product_id'     => $product->id,
            'customer_name'  => $request->customer_email, 
            'customer_phone' => $request->customer_phone,
            'target_user_id' => $request->target_user_id,
            'amount'         => $totalAmount, // Nominal yang akan ditagih Midtrans
            'payment_status' => 'pending',
            'topup_status'   => 'pending',
        ]);

        // 4. Minta Token ke Midtrans
        $snapToken = $midtransService->createSnapToken([
            'order_id'       => $transaction->order_id,
            'amount'         => $transaction->amount,
            'customer_name'  => 'Pelanggan',
            'customer_email' => $request->customer_email,
            'customer_phone' => $transaction->customer_phone,
            'product_sku'    => $product->sku_code,
            'product_name'   => $product->name . " (+PPN 11%)",
        ]);

        if (!$snapToken) {
            return response()->json(['success' => false, 'message' => 'Gagal mendapatkan token'], 500);
        }

        return response()->json(['success' => true, 'snap_token' => $snapToken]);
    }
}