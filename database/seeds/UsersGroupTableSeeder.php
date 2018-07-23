<?php

use Illuminate\Database\Seeder;

class UsersGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_group')->insert([
            'name' => 'Unassigned users',
            'id' => 1,
        ]);
        DB::table('user_group')->insert([
            'name' => 'Development',
            'id' => 2,
        ]);
        DB::table('user_group')->insert([
            'name' => 'Business Support',
            'id' => 3,
        ]);
        DB::table('user_group')->insert([
            'name' => 'Sale',
            'id' => 4,
        ]);
    }
}
