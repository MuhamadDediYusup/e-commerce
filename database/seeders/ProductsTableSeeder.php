<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            // Sayuran
            [
                'id' => 1,
                'category_id' => 1,
                'title' => 'Bayam Segar',
                'slug' => 'bayam-segar',
                'summary' => '<p>Bayam organik segar.</p>',
                'description' => '<p>Bayam kaya akan vitamin dan baik untuk kesehatan.</p>',
                'photo' => '/storage/photos/1/Products/bayam.jpg',
                'stock' => 100,
                'status' => 'active',
                'price' => 5000.00,
                'discount' => 0.00,
                'is_featured' => 0,
                'weight' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'category_id' => 1,
                'title' => 'Wortel Segar',
                'slug' => 'wortel-segar',
                'summary' => '<p>Wortel berkualitas tinggi.</p>',
                'description' => '<p>Cocok untuk sayur atau jus sehat.</p>',
                'photo' => '/storage/photos/1/Products/wortel.jpg',
                'stock' => 200,
                'status' => 'active',
                'price' => 7000.00,
                'discount' => 0.00,
                'is_featured' => 1,
                'weight' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'category_id' => 1,
                'title' => 'Brokoli Segar',
                'slug' => 'brokoli-segar',
                'summary' => '<p>Brokoli hijau segar.</p>',
                'description' => '<p>Brokoli kaya serat dan nutrisi.</p>',
                'photo' => '/storage/photos/1/Products/brokoli.jpg',
                'stock' => 150,
                'status' => 'active',
                'price' => 15000.00,
                'discount' => 5.00,
                'is_featured' => 1,
                'weight' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'category_id' => 1,
                'title' => 'Kangkung',
                'slug' => 'kangkung',
                'summary' => '<p>Kangkung segar langsung dari petani.</p>',
                'description' => '<p>Sayuran hijau yang cocok untuk tumisan.</p>',
                'photo' => '/storage/photos/1/Products/kangkung.jpg',
                'stock' => 100,
                'status' => 'active',
                'price' => 4000.00,
                'discount' => 0.00,
                'is_featured' => 0,
                'weight' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'category_id' => 1,
                'title' => 'Selada Segar',
                'slug' => 'selada-segar',
                'summary' => '<p>Selada hijau segar.</p>',
                'description' => '<p>Cocok untuk salad dan hiasan makanan.</p>',
                'photo' => '/storage/photos/1/Products/selada.jpg',
                'stock' => 80,
                'status' => 'active',
                'price' => 10000.00,
                'discount' => 0.00,
                'is_featured' => 1,
                'weight' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Buah
            [
                'id' => 6,
                'category_id' => 2,
                'title' => 'Apel Merah',
                'slug' => 'apel-merah',
                'summary' => '<p>Apel merah manis dan segar.</p>',
                'description' => '<p>Sumber vitamin yang baik untuk kesehatan.</p>',
                'photo' => '/storage/photos/1/Products/apel-merah.jpg',
                'stock' => 120,
                'status' => 'active',
                'price' => 20000.00,
                'discount' => 2.00,
                'is_featured' => 1,
                'weight' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'category_id' => 2,
                'title' => 'Pisang Cavendish',
                'slug' => 'pisang-cavendish',
                'summary' => '<p>Pisang premium segar.</p>',
                'description' => '<p>Cocok untuk camilan sehat.</p>',
                'photo' => '/storage/photos/1/Products/pisang.jpg',
                'stock' => 180,
                'status' => 'active',
                'price' => 15000.00,
                'discount' => 0.00,
                'is_featured' => 0,
                'weight' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'category_id' => 2,
                'title' => 'Jeruk Manis',
                'slug' => 'jeruk-manis',
                'summary' => '<p>Jeruk segar dan manis.</p>',
                'description' => '<p>Sumber vitamin C.</p>',
                'photo' => '/storage/photos/1/Products/jeruk.jpg',
                'stock' => 130,
                'status' => 'active',
                'price' => 12000.00,
                'discount' => 0.00,
                'is_featured' => 1,
                'weight' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'category_id' => 2,
                'title' => 'Semangka',
                'slug' => 'semangka',
                'summary' => '<p>Semangka merah segar.</p>',
                'description' => '<p>Cocok untuk dikonsumsi saat cuaca panas.</p>',
                'photo' => '/storage/photos/1/Products/semangka.jpg',
                'stock' => 50,
                'status' => 'active',
                'price' => 25000.00,
                'discount' => 5.00,
                'is_featured' => 1,
                'weight' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'category_id' => 2,
                'title' => 'Mangga Harum Manis',
                'slug' => 'mangga-harum-manis',
                'summary' => '<p>Mangga harum manis segar.</p>',
                'description' => '<p>Sangat manis dan kaya serat.</p>',
                'photo' => '/storage/photos/1/Products/mangga.jpg',
                'stock' => 100,
                'status' => 'active',
                'price' => 30000.00,
                'discount' => 10.00,
                'is_featured' => 1,
                'weight' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11,
                'category_id' => 1,
                'title' => 'Tomat Segar',
                'slug' => 'tomat-segar',
                'summary' => '<p>Tomat merah segar.</p>',
                'description' => '<p>Cocok untuk salad, jus, dan masakan.</p>',
                'photo' => '/storage/photos/1/Products/tomat.jpg',
                'stock' => 120,
                'status' => 'active',
                'price' => 6000.00,
                'discount' => 0.00,
                'is_featured' => 0,
                'weight' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12,
                'category_id' => 1,
                'title' => 'Buncis',
                'slug' => 'buncis',
                'summary' => '<p>Buncis segar untuk masakan.</p>',
                'description' => '<p>Sayuran hijau dengan kandungan nutrisi tinggi.</p>',
                'photo' => '/storage/photos/1/Products/buncis.jpg',
                'stock' => 90,
                'status' => 'active',
                'price' => 8000.00,
                'discount' => 0.00,
                'is_featured' => 0,
                'weight' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 13,
                'category_id' => 1,
                'title' => 'Kol Putih',
                'slug' => 'kol-putih',
                'summary' => '<p>Kol segar untuk berbagai masakan.</p>',
                'description' => '<p>Sumber serat dan vitamin.</p>',
                'photo' => '/storage/photos/1/Products/kol.jpg',
                'stock' => 80,
                'status' => 'active',
                'price' => 5000.00,
                'discount' => 0.00,
                'is_featured' => 0,
                'weight' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 14,
                'category_id' => 1,
                'title' => 'Labuan',
                'slug' => 'labuan',
                'summary' => '<p>Labuan segar, cocok untuk sayur.</p>',
                'description' => '<p>Sayuran ini sering digunakan untuk masakan tradisional.</p>',
                'photo' => '/storage/photos/1/Products/labuan.jpg',
                'stock' => 60,
                'status' => 'active',
                'price' => 7000.00,
                'discount' => 0.00,
                'is_featured' => 0,
                'weight' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 15,
                'category_id' => 1,
                'title' => 'Terong Ungu',
                'slug' => 'terong-ungu',
                'summary' => '<p>Terong ungu segar.</p>',
                'description' => '<p>Sayur serbaguna untuk berbagai masakan.</p>',
                'photo' => '/storage/photos/1/Products/terong.jpg',
                'stock' => 100,
                'status' => 'active',
                'price' => 5000.00,
                'discount' => 0.00,
                'is_featured' => 1,
                'weight' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Buah
            [
                'id' => 16,
                'category_id' => 2,
                'title' => 'Pepaya California',
                'slug' => 'pepaya-california',
                'summary' => '<p>Pepaya manis dan segar.</p>',
                'description' => '<p>Sumber vitamin A dan C.</p>',
                'photo' => '/storage/photos/1/Products/pepaya.jpg',
                'stock' => 70,
                'status' => 'active',
                'price' => 15000.00,
                'discount' => 2.00,
                'is_featured' => 1,
                'weight' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 17,
                'category_id' => 2,
                'title' => 'Anggur Merah',
                'slug' => 'anggur-merah',
                'summary' => '<p>Anggur merah manis.</p>',
                'description' => '<p>Cocok untuk pencuci mulut dan camilan sehat.</p>',
                'photo' => '/storage/photos/1/Products/anggur.jpg',
                'stock' => 50,
                'status' => 'active',
                'price' => 30000.00,
                'discount' => 10.00,
                'is_featured' => 1,
                'weight' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 18,
                'category_id' => 2,
                'title' => 'Melon Hijau',
                'slug' => 'melon-hijau',
                'summary' => '<p>Melon hijau segar.</p>',
                'description' => '<p>Manis dan kaya air, cocok untuk camilan sehat.</p>',
                'photo' => '/storage/photos/1/Products/melon.jpg',
                'stock' => 40,
                'status' => 'active',
                'price' => 25000.00,
                'discount' => 5.00,
                'is_featured' => 0,
                'weight' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 19,
                'category_id' => 2,
                'title' => 'Durian Monthong',
                'slug' => 'durian-monthong',
                'summary' => '<p>Durian premium Monthong.</p>',
                'description' => '<p>Durian dengan rasa khas dan tekstur lembut.</p>',
                'photo' => '/storage/photos/1/Products/durian.jpg',
                'stock' => 30,
                'status' => 'active',
                'price' => 50000.00,
                'discount' => 15.00,
                'is_featured' => 1,
                'weight' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 20,
                'category_id' => 2,
                'title' => 'Nanas Palembang',
                'slug' => 'nanas-palembang',
                'summary' => '<p>Nanas manis khas Palembang.</p>',
                'description' => '<p>Sangat cocok untuk jus atau makan langsung.</p>',
                'photo' => '/storage/photos/1/Products/nanas.jpg',
                'stock' => 80,
                'status' => 'active',
                'price' => 15000.00,
                'discount' => 3.00,
                'is_featured' => 0,
                'weight' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
