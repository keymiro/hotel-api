<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hotels')->insert([
            'name'            =>'DECAMERON CARTAGENA',
            'city'            =>'CARTAGENA',
            'address'         =>'CALLE 23 58-25',
            'nit'             =>'12345678-9',
            'max_rooms'       =>'3',
            'user_created_id' => 1
        ]);
    }
}
