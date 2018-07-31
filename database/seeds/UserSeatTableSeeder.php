<?php

use Illuminate\Database\Seeder;

class UserSeatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_seats')->insert([
            'seat_map_id' => 1,
            'user_id' => 1,
            'X' => 100000,
            'Y' => 500000,
        ]);
        DB::table('user_seats')->insert([
            'seat_map_id' => 1,
            'user_id' => 2,
            'X' => 500000,
            'Y' => 500000,
        ]);
        DB::table('user_seats')->insert([
            'seat_map_id' => 1,
            'user_id' => 3,
            'X' => 900000,
            'Y' => 500000,
        ]);
    }
}
