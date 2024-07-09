<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'id' => 1,
                'category_id' => 1,
                'title' => 'Paket Sayuran',
                'slug' => 'paket-sayuran',
                'summary' => '<p>Paket Sayuran<br></p>',
                'description' => '<p>Paket Sayuran<br></p>',
                'photo' => '/storage/photos/1/Products/above-a-box-of-vegetables-_above-a-box-of-vegetables-_full01.jpg',
                'stock' => 5,
                'status' => 'active',
                'price' => 12000.00,
                'discount' => 2.00,
                'is_featured' => 1,
                'created_at' => '2024-07-10 06:02:49',
                'updated_at' => '2024-07-10 06:08:38',
            ],
            [
                'id' => 2,
                'category_id' => 2,
                'title' => 'Paket Sayuran Hijau',
                'slug' => 'buah-tomat',
                'summary' => '<p>Paket Sayuran Hijau</p>',
                'description' => '<p>- Sayur Bayam</p><p>- Sayur Wortel</p>',
                'photo' => '/storage/photos/1/Products/sayur mix-700x700-product_popup.jpg',
                'stock' => 5,
                'status' => 'active',
                'price' => 12000.00,
                'discount' => 5.00,
                'is_featured' => 1,
                'created_at' => '2024-07-10 06:03:31',
                'updated_at' => '2024-07-10 06:10:26',
            ],
        ]);
    }
}
