<?php

use Illuminate\Database\Seeder;

class SeatmapTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seat_maps')->insert([
            'id' => 1,
            'name' => 'Seat map 1'
        ]);
        DB::table('seat_maps')->insert([
            'id' => 2,
            'name' => 'Seat map 2'
        ]);
        DB::table('seat_maps')->insert([
            'id' => 3,
            'name' => 'Seat map 3'
        ]);
    }
}
