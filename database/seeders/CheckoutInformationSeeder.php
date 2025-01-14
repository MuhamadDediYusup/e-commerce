<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CheckoutInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('checkout_information')->insert([
            [
                'user_id' => 1,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'johndoe@example.com',
                'phone_number' => '081234567890',
                'country' => 'Indonesia',
                'address_line1' => 'Jl. Raya No. 1',
                'address_line2' => 'Blok B',
                'postal_code' => '12345',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'janesmith@example.com',
                'phone_number' => '081987654321',
                'country' => 'Indonesia',
                'address_line1' => 'Jl. Pahlawan No. 5',
                'address_line2' => null,
                'postal_code' => '54321',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
