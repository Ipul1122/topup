<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;

class TestMidtransCallback extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:midtrans-callback {order_id} {--url=http://127.0.0.1:8000/api/callback/midtrans}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate Midtrans Webhook callback for a specific transaction';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderId = $this->argument('order_id');
        $url = $this->option('url');

        $transaction = Transaction::where('order_id', $orderId)->first();

        if (!$transaction) {
            $this->error("Transaction not found for Order ID: {$orderId}");
            return 1;
        }

        $this->info("Found transaction: {$transaction->order_id} with amount: {$transaction->amount}");

        // Format gross amount to match Midtrans payload structure (usually 2 decimal places or exact match)
        $grossAmount = number_format($transaction->amount, 2, '.', '');
        $statusCode = '200';
        $serverKey = config('midtrans.server_key');

        // SHA512(order_id + status_code + gross_amount + server_key)
        $signatureKey = hash('sha512', $transaction->order_id . $statusCode . $grossAmount . $serverKey);

        $payload = [
            'order_id'           => $transaction->order_id,
            'status_code'        => $statusCode,
            'gross_amount'       => $grossAmount,
            'signature_key'      => $signatureKey,
            'transaction_status' => 'settlement',
            'payment_type'       => 'qris',
            'transaction_id'     => 'mock-trans-id-' . uniqid(),
            'fraud_status'       => 'accept',
        ];

        $this->info("Sending simulated Midtrans POST request to {$url}...");
        $this->line(json_encode($payload, JSON_PRETTY_PRINT));

        try {
            $response = Http::post($url, $payload);

            $this->info("HTTP Status Code: " . $response->status());
            $this->line("Response Body: " . $response->body());

            if ($response->successful()) {
                $this->info("Callback successfully simulated!");
                
                // Refresh transaction state from DB to show updated columns
                $transaction->refresh();
                $this->line("\nCurrent Database State for Order ID {$transaction->order_id}:");
                $this->line("- Payment Status: " . $transaction->payment_status);
                $this->line("- Topup Status:   " . $transaction->topup_status);
                $this->line("- Serial Number:  " . ($transaction->sn ?? 'N/A'));
            } else {
                $this->error("Callback simulation returned failure.");
            }
        } catch (\Exception $e) {
            $this->error("Failed to send request: " . $e->getMessage());
        }

        return 0;
    }
}
