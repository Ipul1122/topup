<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Services\ApigamesService;
use Illuminate\Support\Facades\Log;

class CallbackController extends Controller
{
    public function midtrans(Request $request, ApigamesService $apigamesService)
    {
        $payload = $request->all();
        Log::info('Webhook Midtrans Masuk: ', $payload); // Catat di log untuk debugging

        // 1. Validasi Keamanan (Signature Key)
        $orderId = $payload['order_id'];
        $statusCode = $payload['status_code'];
        $grossAmount = $payload['gross_amount'];
        $reqSignature = $payload['signature_key'];
        
        $serverKey = config('midtrans.server_key');
        // Rumus wajib Midtrans: SHA512(order_id + status_code + gross_amount + server_key)
        $mySignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($mySignature !== $reqSignature) {
            Log::warning('Midtrans Invalid Signature: ' . $orderId);
            return response()->json(['success' => false, 'message' => 'Invalid signature'], 401);
        }

        // 2. Cari Data Transaksi di MySQL
        $transaction = Transaction::where('order_id', $orderId)->first();
        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaction not found'], 404);
        }

        // 3. Eksekusi Berdasarkan Status Midtrans
        $transactionStatus = $payload['transaction_status'];

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            // Pastikan belum diproses sebelumnya (mencegah double top-up)
            if ($transaction->payment_status !== 'paid') {
                
                // Ubah status pembayaran jadi Lunas
                $transaction->update(['payment_status' => 'paid', 'topup_status' => 'processing']);

                // OTOMATIS TEMBAK APIGAMES DI SINI!
                $topupResponse = $apigamesService->topup(
                    $transaction->order_id, 
                    $transaction->product->sku_code, 
                    $transaction->target_user_id
                );

                // Cek hasil dari APIGames
                if (isset($topupResponse['status']) && $topupResponse['status'] == 1) {
                    $sn = $topupResponse['data']['sn'] ?? 'Sukses';
                    $transaction->update(['topup_status' => 'success', 'sn' => $sn]);
                    Log::info("Top Up Sukses: " . $orderId);
                } else {
                    $transaction->update(['topup_status' => 'failed']);
                    Log::error("Top Up Gagal di APIGames: ", $topupResponse);
                }
            }
        } elseif (in_array($transactionStatus, ['expire', 'cancel', 'deny'])) {
            $transaction->update(['payment_status' => 'failed', 'topup_status' => 'failed']);
        }

        return response()->json(['success' => true, 'message' => 'Callback processed']);
    }
}