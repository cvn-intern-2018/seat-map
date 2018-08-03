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
            'X' => 1000,
            'Y' => 5000,
        ]);
        DB::table('user_seats')->insert([
            'seat_map_id' => 1,
            'user_id' => 2,
            'X' => 5000,
            'Y' => 5000,
        ]);
        DB::table('user_seats')->insert([
            'seat_map_id' => 1,
            'user_id' => 3,
            'X' => 9000,
            'Y' => 5000,
        ]);
    }
}
