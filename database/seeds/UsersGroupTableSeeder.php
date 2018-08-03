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
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('user_groups')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        DB::table('user_groups')->insert([
            'name' => 'Unassigned users',
            'id' => 1,
        ]);
        factory(App\UserGroup::class, 4)->create();
    }
}
