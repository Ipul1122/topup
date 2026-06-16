<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApigamesService
{
    private string $merchantId;
    private string $secretKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->merchantId = config('apigames.merchant_id');
        $this->secretKey = config('apigames.secret_key');
        $this->baseUrl = config('apigames.base_url');
    }

    /**
     * Generate Signature MD5 (Merchant ID + Secret Key)
     */
    private function generateSignature(): string
    {
        return md5($this->merchantId . $this->secretKey);
    }

    /**
     * Get Info Akun (Saldo & Profil Merchant)
     */
    public function getMerchantInfo(): array
    {
        $endpoint = $this->baseUrl . config('apigames.endpoints.merchant') . '/' . $this->merchantId;
        
        try {
            $response = Http::get($endpoint, [
                'signature' => $this->generateSignature(),
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('APIGames Get Info Error: ' . $e->getMessage());
            return ['status' => 0, 'message' => 'Terjadi kesalahan sistem'];
        }
    }

    /**
     * Cek Akun Game (Validasi Nickname)
     */
    public function checkUsername(string $gameCode, string $userId): array
    {
        $endpoint = $this->baseUrl . config('apigames.endpoints.merchant') . '/' . $this->merchantId . '/cek-username/' . $gameCode;
        
        try {
            $response = Http::get($endpoint, [
                'user_id'   => $userId,
                'signature' => $this->generateSignature(),
            ]);

            // Antisipasi jika APIGames mengembalikan halaman HTML/Error bukan JSON
            $data = $response->json();
            if ($data === null) {
                return [
                    'status'   => 0,
                    'message'  => 'Response gagal di-parsing ke JSON',
                    'raw_body' => $response->body()
                ];
            }

            return $data;

        } catch (\Exception $e) {
            // Kita tampilkan error aslinya ke Postman
            return [
                'status'  => 0, 
                'message' => 'Gagal mengecek username',
                'error'   => $e->getMessage(),
                'url'     => $endpoint // Cek apakah URL ini sudah benar atau ada double slash
            ];
        }
    }

    public function getProducts(): array
    {
        // Sesuaikan endpoint ini dengan dokumentasi APIGames lu
        // Biasanya /merchant/[merchant_id]/katalog atau semacamnya
        $endpoint = $this->baseUrl . config('apigames.endpoints.merchant') . '/' . $this->merchantId . '/katalog';
        
        try {
            $response = Http::get($endpoint, [
                'signature' => $this->generateSignature(),
            ]);

            return $response->json() ?? [];
        } catch (\Exception $e) {
            Log::error('APIGames Get Products Error: ' . $e->getMessage());
            return ['status' => 0, 'message' => 'Gagal menarik data produk'];
        }
    }

    /**
     * Eksekusi Transaksi Top Up (V2)
     */
    public function topup(string $refId, string $skuCode, string $targetUserId): array
    {
        $endpoint = $this->baseUrl . config('apigames.endpoints.transaksi');
        
        // APIGames V2 wajib signature dengan format: md5(merchant_id:secret_key:ref_id)
        $signature = md5(trim($this->merchantId) . ':' . trim($this->secretKey) . ':' . trim($refId));

        $tujuan = trim($targetUserId);
        $serverId = '';

        // Jika format targetUserId adalah userID(zoneID), contoh: 12345678(1234)
        if (preg_match('/^([^\(\)]+)\(([^ \(\)]+)\)$/', $tujuan, $matches)) {
            $tujuan = trim($matches[1]);
            $serverId = trim($matches[2]);
        }

        // Jalur mapping otomatis untuk pengujian (H2H UniPin -> Direct DgRings)
        if ($skuCode === 'UPMBL5') {
            $skuCode = 'DGRMBL3';
        }

        try {
            $response = Http::post($endpoint, [
                'ref_id'      => $refId,
                'merchant_id' => $this->merchantId,
                'produk'      => $skuCode,
                'tujuan'      => $tujuan,
                'server_id'   => $serverId,
                'signature'   => $signature,
            ]);

            return $response->json() ?? [];
        } catch (\Exception $e) {
            Log::error('APIGames Topup Error: ' . $e->getMessage());
            return ['status' => 0, 'message' => 'Gagal hit API Provider'];
        }
    }

    /**
     * Cek Status Transaksi di APIGames (V2)
     */
    public function checkTransactionStatus(string $refId): array
    {
        $endpoint = $this->baseUrl . config('apigames.endpoints.transaksi') . '/status';
        
        // Signature: md5(merchant_id:secret_key:ref_id)
        $signature = md5(trim($this->merchantId) . ':' . trim($this->secretKey) . ':' . trim($refId));

        try {
            $response = Http::get($endpoint, [
                'merchant_id' => $this->merchantId,
                'ref_id'      => $refId,
                'signature'   => $signature,
            ]);

            return $response->json() ?? [];
        } catch (\Exception $e) {
            Log::error('APIGames Check Transaction Status Error: ' . $e->getMessage());
            return ['status' => 0, 'message' => 'Gagal mengecek status transaksi'];
        }
    }
}