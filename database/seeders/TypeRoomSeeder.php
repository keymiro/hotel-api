<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_rooms')->insert([
            'name'        =>'Estándar',
            'accommodations'=> json_encode([
                'Sencilla',
                'Doble'
            ])
        ]);

        DB::table('type_rooms')->insert([
            'name'          =>'Junior',
            'accommodations'=> json_encode([
                'Triple',
                'Cuádruple'
            ])
        ]);

        DB::table('type_rooms')->insert([
            'name'          =>'Suite',
            'accommodations'=> json_encode([
                'Sencilla',
                'Doble',
                'Triple'
            ])
        ]);
    }
}
