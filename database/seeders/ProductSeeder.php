<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category\Game as Category;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // 1. Mobile Legends Category & Products
        $mlCategoryName = 'Mobile Legends';
        $mlCategory = Category::updateOrCreate(
            ['brand_code' => 'mobilelegend'],
            [
                'name' => $mlCategoryName,
                'slug' => Str::slug($mlCategoryName),
                'is_active' => true,
            ]
        );

        // Hapus produk lama ber-category_id ini agar tidak bentrok
        Product::query()->where('category_id', $mlCategory->id)->delete();

        $mlProducts = [
            [
                'name'           => '5 Diamonds Mobile Legend',
                'sku_code'       => 'ml5',
                'price_provider' => 1480.00,
                'price_sell'     => 2000.00,
                'status'         => 'aktif',
                'is_active'      => true,
            ],
            [
                'name'           => '10 Diamonds Mobile Legend',
                'sku_code'       => 'ml10',
                'price_provider' => 2830.00,
                'price_sell'     => 4000.00,
                'status'         => 'aktif',
                'is_active'      => true,
            ],
            [
                'name'           => '12 Diamonds Mobile Legend',
                'sku_code'       => 'ml12',
                'price_provider' => 3390.00,
                'price_sell'     => 4500.00,
                'status'         => 'aktif',
                'is_active'      => true,
            ],
        ];

        foreach ($mlProducts as $item) {
            Product::updateOrCreate(
                ['sku_code' => $item['sku_code']],
                [
                    'category_id'    => $mlCategory->id,
                    'name'           => $item['name'],
                    'price_provider' => $item['price_provider'],
                    'price_sell'     => $item['price_sell'],
                    'status'         => $item['status'],
                    'is_active'      => $item['is_active'],
                ]
            );
        }

        // 2. Free Fire Category & Products
        $ffCategoryName = 'Free Fire';
        $ffCategory = Category::firstOrCreate(
            ['slug' => Str::slug($ffCategoryName)],
            [
                'name' => $ffCategoryName,
                'is_active' => true,
                'brand_code' => 'freefire'
            ]
        );

        $ffProducts = [
            [
                'name'           => '5 Diamonds Free Fire',
                'sku_code'       => 'FF5',
                'price_provider' => 1000.00,
                'price_sell'     => 1500.00,
                'status'         => 'aktif',
                'is_active'      => true,
            ],
            [
                'name'           => '12 Diamonds Free Fire',
                'sku_code'       => 'FF12',
                'price_provider' => 2000.00,
                'price_sell'     => 3000.00,
                'status'         => 'aktif',
                'is_active'      => true,
            ],
            [
                'name'           => '50 Diamonds Free Fire',
                'sku_code'       => 'FF50',
                'price_provider' => 7000.00,
                'price_sell'     => 9000.00,
                'status'         => 'aktif',
                'is_active'      => true,
            ],
            [
                'name'           => '70 Diamonds Free Fire',
                'sku_code'       => 'FF70',
                'price_provider' => 9500.00,
                'price_sell'     => 12000.00,
                'status'         => 'aktif',
                'is_active'      => true,
            ],
            [
                'name'           => '140 Diamonds Free Fire',
                'sku_code'       => 'FF140',
                'price_provider' => 19000.00,
                'price_sell'     => 23000.00,
                'status'         => 'aktif',
                'is_active'      => true,
            ],
            [
                'name'           => '355 Diamonds Free Fire',
                'sku_code'       => 'FF355',
                'price_provider' => 47000.00,
                'price_sell'     => 55000.00,
                'status'         => 'aktif',
                'is_active'      => true,
            ],
        ];

        foreach ($ffProducts as $item) {
            Product::updateOrCreate(
                ['sku_code' => $item['sku_code']],
                [
                    'category_id'    => $ffCategory->id,
                    'name'           => $item['name'],
                    'price_provider' => $item['price_provider'],
                    'price_sell'     => $item['price_sell'],
                    'status'         => $item['status'],
                    'is_active'      => $item['is_active'],
                ]
            );
        }

        $this->command->info('Produk Mobile Legends & Free Fire berhasil ditanam ke database!');
    }
}