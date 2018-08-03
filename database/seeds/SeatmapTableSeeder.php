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
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('seat_maps')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        factory(App\SeatMap::class, 4)->create();
    }
}
