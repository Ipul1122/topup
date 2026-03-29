<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat Kategori (Model)
        $categoryName = 'Mobile Legend Unipin';
        $category = Category::firstOrCreate(
            ['slug' => Str::slug($categoryName)],
            [
                'name' => $categoryName,
                'is_active' => true,
                'brand_code' => 'mobilelegend'
            ]
        );

        // 2. Siapkan Data Produk (Berdasarkan Screenshot Dashboard APIGames lu)
        $products = [
            [
                'name'           => '5 Diamond Mobile Legend Unipin',
                'sku_code'       => 'UPMBL5',
                'price_provider' => 1449.00,
                'price_sell'     => 2000.00, // Harga jual lu (Untung Rp 551)
                'status'         => 'aktif',
                'is_active'      => true,
            ],
            [
                'name'           => '12 Diamond Mobile Legend Unipin',
                'sku_code'       => 'UPMBL12',
                'price_provider' => 3900.00,
                'price_sell'     => 4500.00, // Untung Rp 600
                'status'         => 'aktif',
                'is_active'      => true,
            ],
            [
                'name'           => '19 Diamond Mobile Legend Unipin',
                'sku_code'       => 'UPMBL19',
                'price_provider' => 5742.00,
                'price_sell'     => 6500.00, // Untung Rp 758
                'status'         => 'aktif',
                'is_active'      => true,
            ],
            [
                'name'           => '28 Diamond Mobile Legend Unipin',
                'sku_code'       => 'UPMBL28',
                'price_provider' => 7830.00,
                'price_sell'     => 8500.00, // Untung Rp 670
                'status'         => 'aktif',
                'is_active'      => true,
            ],
        ];

        // 3. Masukkan ke MySQL
        foreach ($products as $item) {
            Product::updateOrCreate(
                ['sku_code' => $item['sku_code']], // Cek biar gak duplikat
                [
                    'category_id'    => $category->id,
                    'name'           => $item['name'],
                    'price_provider' => $item['price_provider'],
                    'price_sell'     => $item['price_sell'],
                    'status'         => $item['status'],
                    'is_active'      => $item['is_active'],
                ]
            );
        }

        $this->command->info('Produk Mobile Legends berhasil ditanam ke database!');
    }
}