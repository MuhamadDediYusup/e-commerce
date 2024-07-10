<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'id' => 1,
                'title' => 'Sayuran',
                'slug' => 'sayuran',
                'created_at' => '2024-07-10 06:01:37',
                'updated_at' => '2024-07-10 06:01:37',
            ],
            [
                'id' => 2,
                'title' => 'Buah',
                'slug' => 'buah',
                'created_at' => '2024-07-10 06:01:44',
                'updated_at' => '2024-07-10 06:01:44',
            ],
        ]);
    }
}
