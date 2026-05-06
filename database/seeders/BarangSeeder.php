<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'id' => 1,
                'name' => 'Smartphone Galaxy S24',
                'price' => 12999000,
                'originalPrice' => 15999000,
                'rating' => 4.8,
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400',
                'category' => 'Elektronik',
            ],
            [
                'id' => 2,
                'name' => 'Laptop Gaming ROG',
                'price' => 25999000,
                'originalPrice' => 29999000,
                'rating' => 4.9,
                'image' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=400',
                'category' => 'Elektronik',
            ],
            [
                'id' => 3,
                'name' => 'Sepatu Nike Air Max',
                'price' => 1899000,
                'originalPrice' => 2299000,
                'rating' => 4.7,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400',
                'category' => 'Fashion',
            ],
            [
                'id' => 4,
                'name' => 'Kamera DSLR Canon',
                'price' => 8999000,
                'originalPrice' => 10999000,
                'rating' => 4.6,
                'image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=400',
                'category' => 'Elektronik',
            ],
            [
                'id' => 5,
                'name' => 'Headphone Wireless',
                'price' => 999000,
                'originalPrice' => 1299000,
                'rating' => 4.5,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400',
                'category' => 'Elektronik',
            ],
            [
                'id' => 6,
                'name' => 'Jam Tangan Sport',
                'price' => 2499000,
                'originalPrice' => 2999000,
                'rating' => 4.4,
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400',
                'category' => 'Fashion',
            ],
            [
                'id' => 7,
                'name' => 'Tas Backpack Travel',
                'price' => 599000,
                'originalPrice' => 799000,
                'rating' => 4.3,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400',
                'category' => 'Fashion',
            ],
            [
                'id' => 8,
                'name' => 'Smart TV 55 inch',
                'price' => 7999000,
                'originalPrice' => 9999000,
                'rating' => 4.7,
                'image' => 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=400',
                'category' => 'Elektronik',
            ],
        ];

        DB::table('barangs')->insert($products);
    }
}
