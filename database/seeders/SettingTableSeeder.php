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
            'coordinates' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d890.94245168755!2d110.06176418866595!3d-7.252407748601681!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7076bc0541f2cd%3A0xa7da497d968cd782!2sP3W6%2BXR6%2C%20Gagaran%2C%20Kataan%2C%20Kec.%20Ngadirejo%2C%20Kabupaten%20Temanggung%2C%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1729824630470!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'phone' => '+62 812-3456-7890',
            'email' => 'info@berkahtani.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );
        DB::table('settings')->insert($data);
    }
}
