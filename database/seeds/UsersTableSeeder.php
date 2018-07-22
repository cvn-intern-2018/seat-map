<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'admin',
            'password' => bcrypt('123456'),
            'group_id' => 1,
            'email' => 'abc@example.com',
            'permission' => 1
        ]);
        DB::table('users')->insert([
            'id' => 2,
            'name' => 'admin',
            'password' => bcrypt('123456'),
            'group_id' => 1,
            'email' => 'admin@admin.com',
            'permission' => 1
        ]);
        DB::table('users')->insert([
            'id' => 3,
            'name' => 'User',
            'password' => bcrypt('123456'),
            'group_id' => 1,
            'email' => 'user@user.com',
            'permission' => 2
        ]);
        DB::table('users')->insert([
            'id' => 4,
            'name' => 'User A',
            'password' => bcrypt('123456'),
            'group_id' => 1,
            'email' => 'usera@user.com',
            'permission' => 2
        ]);DB::table('users')->insert([
            'id' => 5,
            'name' => 'User B',
            'password' => bcrypt('123456'),
            'group_id' => 1,
            'email' => 'userb@user.com',
            'permission' => 2
        ]);DB::table('users')->insert([
            'id' => 6,
            'name' => 'User C',
            'password' => bcrypt('123456'),
            'group_id' => 1,
            'email' => 'userc@user.com',
            'permission' => 2
        ]);
    }
}
