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
        for ($i = 1; $i < 5; $i++) {
            DB::table('seat_maps')->insert([
                'id' => $i,
                'name' => 'Seat map '.$i,
                'img' => '.png'
            ]);
        }
    }
}
