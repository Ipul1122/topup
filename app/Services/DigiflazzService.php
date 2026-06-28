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
     * Cek Akun Game (Validasi Nickname menggunakan Pascabayar Inquiry)
     */
    public function checkUsername(string $gameCode, string $userId): array
    {
        $endpoint = $this->baseUrl . '/transaction';
        $refId = 'CEK-' . strtoupper($gameCode) . '-' . time();
        
        // Pengecekan username menggunakan Prod Key sesuai petunjuk user
        $prodKey = env('DIGIFLAZZ_API_KEY_PROD');
        $sign = md5($this->username . $prodKey . $refId);

        // Bersihkan customer_no dari karakter non-numerik (misal format 113332888(2576) menjadi 1133328882576)
        $cleanUserId = preg_replace('/[^0-9]/', '', $userId);

        $payload = [
            'commands'       => 'inq-pasca',
            'username'       => $this->username,
            'buyer_sku_code' => 'hp-games',
            'customer_no'    => $cleanUserId,
            'ref_id'         => $refId,
            'sign'           => $sign,
        ];

        try {
            Log::info('Digiflazz Inquiry Request: ', $payload);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($endpoint, $payload);

            Log::info('Digiflazz Inquiry Response: ', [$response->body()]);

            $result = $response->json();

            if (isset($result['data'])) {
                $data = $result['data'];
                $rc = $data['rc'] ?? '';

                if ($rc === '00') {
                    return [
                        'status' => 1,
                        'data'   => $data['tr_name'] ?? 'Username ditemukan'
                    ];
                }

                return [
                    'status'  => 0,
                    'message' => $data['message'] ?? 'Gagal mengecek akun.'
                ];
            }

            return [
                'status'  => 0,
                'message' => 'Format response supplier tidak sesuai.'
            ];

        } catch (\Exception $e) {
            Log::error('Digiflazz Inquiry Error: ' . $e->getMessage());
            return [
                'status'  => 0,
                'message' => 'Terjadi kesalahan sistem internal.'
            ];
        }
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
            'sign'     => md5($this->username . $this->apiKey . 'price'),
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
