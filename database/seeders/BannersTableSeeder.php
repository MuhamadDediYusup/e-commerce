<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banners')->insert([
            'id' => 1,
            'title' => 'Aneka Buah dan Sayuran Segar',
            'slug' => 'aneka-buah-dan-sayuran-segar',
            'photo' => '/storage/photos/1/Banner/baner-01.jpg',
            'description' => '<p>Berkah Tani menyediakan berbagai jenis sayuran segar dan termurah, karena langsung dikirim dari petani sayur.</p>',
            'status' => 'active',
            'created_at' => '2024-07-10 06:14:31',
            'updated_at' => '2024-07-10 06:51:59',
        ]);
    }
}
