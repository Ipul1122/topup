<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DigiflazzService
{
    protected $username;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        // Mengambil data kredensial dari file .env
        $this->username = env('DIGIFLAZZ_USERNAME');
        $this->baseUrl = env('DIGIFLAZZ_BASE_URL', 'https://api.digiflazz.com/v1');
        
        // Deteksi otomatis apakah web dalam mode production atau development
        $this->apiKey = env('MIDTRANS_IS_PRODUCTION', false) 
            ? env('DIGIFLAZZ_API_KEY_PROD') 
            : env('DIGIFLAZZ_API_KEY_DEV');
    }

    /**
     * Fungsi untuk mengeksekusi top up otomatis ke Digiflazz
     */
    public function topup($orderId, $skuCode, $targetNo)
    {
        $endpoint = $this->baseUrl . '/transaction';

        // Rumus enkripsi MD5 yang sudah kita tes sukses di Postman!
        $sign = md5($this->username . $this->apiKey . $orderId);

        try {
            $payload = [
                'username'       => $this->username,
                'buyer_sku_code' => $skuCode,
                'customer_no'    => $targetNo, // Pastikan dari controller sudah digabung user_id + zone_id
                'ref_id'         => $orderId,
                'sign'           => $sign,
                'testing'        => !env('MIDTRANS_IS_PRODUCTION', false) // Otomatis true jika masih sandbox
            ];

            Log::info('Digiflazz Request: ', $payload);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($endpoint, $payload);

            Log::info('Digiflazz Response: ', [$response->body()]);

            if ($response->failed()) {
                return [
                    'success' => false,
                    'message' => 'Gagal terhubung ke server supplier.'
                ];
            }

            $result = $response->json();

            // Membaca object 'data' di dalam response Digiflazz
            if (isset($result['data'])) {
                $data = $result['data'];
                
                // Status di Digiflazz: 'Sukses', 'Gagal', atau 'Pending'
                return [
                    'success' => true,
                    'status'  => $data['status'], 
                    'rc'      => $data['rc'],
                    'message' => $data['message'],
                    'sn'      => $data['sn'] ?? ''
                ];
            }

            return [
                'success' => false,
                'message' => 'Format response supplier tidak sesuai.'
            ];

        } catch (\Exception $e) {
            Log::error('Digiflazz Service Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan sistem internal.'
            ];
        }
    }

    /**
     * Get Info Akun (Saldo & Profil Merchant)
     */
    public function getMerchantInfo(): array
    {
        $endpoint = $this->baseUrl . '/cek-saldo';
        $payload = [
            'cmd'      => 'deposit',
            'username' => $this->username,
            'sign'     => md5($this->username . $this->apiKey . 'depo'),
        ];

        try {
            $response = Http::post($endpoint, $payload);
            return $response->json() ?? [];
        } catch (\Exception $e) {
            Log::error('Digiflazz Get Info Error: ' . $e->getMessage());
            return ['status' => 0, 'message' => 'Terjadi kesalahan sistem'];
        }
    }

    /**
     * Cek Akun Game (Validasi Nickname - Mocked because Digiflazz doesn't support separate username check)
     */
    public function checkUsername(string $gameCode, string $userId): array
    {
        return [
            'status' => 1,
            'data'   => 'Pengecekan username tidak tersedia di Digiflazz (ID: ' . $userId . ')'
        ];
    }

    /**
     * Get Products Price List
     */
    public function getProducts(): array
    {
        $endpoint = $this->baseUrl . '/price-list';
        $payload = [
            'cmd'      => 'prepaid',
            'username' => $this->username,
            'sign'     => md5($this->username . $this->apiKey . 'pricelist'),
        ];

        try {
            $response = Http::post($endpoint, $payload);
            return $response->json() ?? [];
        } catch (\Exception $e) {
            Log::error('Digiflazz Get Products Error: ' . $e->getMessage());
            return ['status' => 0, 'message' => 'Gagal menarik data produk'];
        }
    }

    /**
     * Cek Status Transaksi di Digiflazz (Prepaid)
     */
    public function checkTransactionStatus(string $refId, string $skuCode, string $targetUserId): array
    {
        return $this->topup($refId, $skuCode, $targetUserId);
    }
}
