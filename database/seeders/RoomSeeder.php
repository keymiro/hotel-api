<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            'number'          =>'100',
            'amount'           =>70000,
            'accommodations'   =>'Sencilla',
            'type_room_id'    =>1,
            'hotel_id'        =>1,
            'user_created_id' =>1
        ]);

        DB::table('rooms')->insert([
            'number'          =>'101',
            'amount'           =>100000,
            'accommodations'   =>'Cuádruple',
            'type_room_id'    =>2,
            'hotel_id'        =>1,
            'user_created_id' =>1
        ]);

        DB::table('rooms')->insert([
            'number'          =>'102',
            'amount'           =>150000,
            'accommodations'   =>'Doble',
            'type_room_id'    =>3,
            'hotel_id'        =>1,
            'user_created_id' =>1
        ]);
    }
}
