<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            'description' => 'Berkah Tani adalah platform e-commerce yang menyediakan berbagai produk pertanian berkualitas tinggi. Kami mendukung petani lokal dengan menyediakan tempat bagi mereka untuk menjual hasil panen mereka langsung ke konsumen.',
            'short_des' => 'E-commerce produk pertanian yang mendukung petani lokal.',
            'photo' => "image.jpg",
            'logo' => '/storage/photos/1/logo.png',
            'address' => 'Jl. Pertanian No. 123, Tulungagung, Indonesia',
            'phone' => '+62 812-3456-7890',
            'email' => 'info@berkahtani.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );
        DB::table('settings')->insert($data);
    }
}
