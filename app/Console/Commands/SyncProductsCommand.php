<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DigiflazzService;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class SyncProductsCommand extends Command
{
    // Ini command yang akan lu ketik di terminal nanti
    protected $signature = 'app:sync-products';
    protected $description = 'Menarik dan sinkronisasi produk dari Digiflazz ke Database';

    public function handle(DigiflazzService $digiflazzService)
    {
        $this->info('Memulai sinkronisasi produk dari Digiflazz...');

        // 1. Panggil Context Service
        $response = $digiflazzService->getProducts();

        if (!isset($response['data']) || empty($response['data'])) {
            $this->error('Gagal mengambil data dari provider.');
            return;
        }

        $products = $response['data'];
        $count = 0;

        // 2. Mapping Data ke MySQL (Model)
        foreach ($products as $item) {
            $brand = $item['brand'] ?? '';
            if (empty($brand)) {
                continue;
            }

            // Normalisasi brand_code
            $brandCode = strtolower(str_replace([' ', '-'], '', $brand));
            if ($brandCode === 'mobilelegends') {
                $brandCode = 'mobilelegend';
            }

            // Filter agar hanya menyinkronkan mobile Legends dan Free Fire
            if (!in_array($brandCode, ['mobilelegend', 'freefire'])) {
                continue;
            }

            // Cari atau buat kategori
            $category = Category::firstOrCreate(
                ['brand_code' => $brandCode],
                [
                    'name'      => $brand,
                    'slug'      => Str::slug($brand),
                    'is_active' => true,
                ]
            );

            // Tentukan status produk aktif/nonaktif dari Digiflazz
            $isActive = ($item['buyer_product_status'] ?? false) && ($item['seller_product_status'] ?? false);

            // Update atau buat produk baru
            Product::updateOrCreate(
                ['sku_code' => $item['buyer_sku_code']],
                [
                    'category_id'    => $category->id,
                    'name'           => $item['product_name'],
                    'price_provider' => $item['price'] ?? 0,
                    // Logic harga jual: Modal + Markup (misal untung Rp 2.000)
                    'price_sell'     => ($item['price'] ?? 0) + 2000, 
                    'is_active'      => $isActive,
                    'status'         => $isActive ? 'aktif' : 'inactive',
                ]
            );
            $count++;
        }

        $this->info("Sinkronisasi selesai! Berhasil update/simpan {$count} produk.");
    }
}