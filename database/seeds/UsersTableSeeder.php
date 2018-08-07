<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('123456'),
            'user_group_id' => 1,
            'email' => 'admin@admin.com',
            'short_name' => 'Admin',
            'permission' => 1,
            'phone' => '01237015928',
            'img' => '.jpg',
        ]);
        factory(App\User::class, 10)->create([
            'phone' => '0123456789',
        ]);
    }
}
