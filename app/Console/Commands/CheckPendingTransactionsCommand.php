<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Services\ApigamesService;
use Illuminate\Support\Facades\Log;

class CheckPendingTransactionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'topup:check-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek status transaksi pending di APIGames';

    /**
     * Execute the console command.
     */
    public function handle(ApigamesService $apigamesService)
    {
        $this->info('Memulai pengecekan transaksi pending di APIGames...');

        // Cari transaksi yang pembayarannya sukses (paid) tapi status topupnya masih pending / processing
        $transactions = Transaction::where('payment_status', 'paid')
            ->whereIn('topup_status', ['pending', 'processing'])
            ->get();

        if ($transactions->isEmpty()) {
            $this->info('Tidak ada transaksi pending untuk dicek.');
            return;
        }

        $this->info('Ditemukan ' . $transactions->count() . ' transaksi pending.');

        foreach ($transactions as $transaction) {
            $this->info("Mengecek Order ID: {$transaction->order_id}...");

            $response = $apigamesService->checkTransactionStatus($transaction->order_id);

            // Log response untuk debugging
            Log::info("CheckPendingCommand response for {$transaction->order_id}: ", $response);

            if (isset($response['status']) && $response['status'] == 1) {
                $data = $response['data'] ?? [];
                $status = $data['status'] ?? '';
                $sn = $data['sn'] ?? null;

                if (strcasecmp($status, 'Sukses') === 0) {
                    $transaction->update([
                        'topup_status' => 'success',
                        'sn'           => $sn ?? 'Sukses'
                    ]);
                    $this->info("Order ID {$transaction->order_id} UPDATED to SUCCESS. SN: " . ($sn ?? '-'));
                } elseif (strcasecmp($status, 'Gagal') === 0) {
                    $transaction->update([
                        'topup_status' => 'failed',
                        'sn'           => $sn ?? 'Gagal'
                    ]);
                    $this->warn("Order ID {$transaction->order_id} UPDATED to FAILED. Reason: " . ($sn ?? 'Gagal'));
                } else {
                    $this->info("Order ID {$transaction->order_id} masih berstatus: {$status}");
                }
            } else {
                $errorMsg = $response['error_msg'] ?? 'Gagal cek status';
                $this->error("Gagal mengecek Order ID {$transaction->order_id}: {$errorMsg}");
            }
        }

        $this->info('Selesai mengecek transaksi pending.');
    }
}
