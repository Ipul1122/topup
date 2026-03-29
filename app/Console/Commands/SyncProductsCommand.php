<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ApigamesService;
use App\Models\Category;
use App\Models\Product;

class SyncProductsCommand extends Command
{
    // Ini command yang akan lu ketik di terminal nanti
    protected $signature = 'app:sync-products';
    protected $description = 'Menarik dan sinkronisasi produk dari APIGames ke Database';

    public function handle(ApigamesService $apigamesService)
    {
        $this->info('Memulai sinkronisasi produk dari APIGames...');

        // 1. Panggil Context Service
        $response = $apigamesService->getProducts();

        if (!isset($response['data']) || $response['status'] == 0) {
            $this->error('Gagal mengambil data dari provider.');
            return;
        }

        $products = $response['data'];
        $count = 0;

        // 2. Mapping Data ke MySQL (Model)
        foreach ($products as $item) {
            // Asumsi struktur JSON: $item['game'], $item['kode'], $item['nama'], $item['harga']
            // (Sesuaikan array key ini dengan struktur JSON asli dari APIGames lu)
            
            // Cari atau buat kategori
            $category = Category::firstOrCreate(
                ['brand_code' => $item['game']], // Pastikan key 'game' sesuai response API
                ['name' => strtoupper($item['game'])]
            );

            // Update atau buat produk baru
            Product::updateOrCreate(
                ['sku_code' => $item['kode']], // Pastikan key 'kode' sesuai response API
                [
                    'category_id'    => $category->id,
                    'name'           => $item['nama'],
                    'price_provider' => $item['harga'],
                    // Logic harga jual: Modal + Markup (misal untung Rp 2.000)
                    'price_sell'     => $item['harga'] + 2000, 
                    'is_active'      => true,
                ]
            );
            $count++;
        }

        $this->info("Sinkronisasi selesai! Berhasil update/simpan {$count} produk.");
    }
}