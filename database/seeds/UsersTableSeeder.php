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
            'name' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('123456'),
            'group_id' => 1,
            'email' => 'admin@admin.com',
            'short_name' => 'Admin',
            'permission' => 1
        ]);
        DB::table('users')->insert([
            'id' => 2,
            'name' => 'user1',
            'username' => 'user1',
            'password' => bcrypt('123456'),
            'group_id' => 1,
            'email' => 'user1@user.com',
            'short_name' => 'user1',
            'permission' => 1
        ]);
        DB::table('users')->insert([
            'id' => 3,
            'name' => 'user2',
            'username' => 'user2',
            'password' => bcrypt('123456'),
            'group_id' => 1,
            'email' => 'user2@user.com',
            'short_name' => 'user2',
            'permission' => 1
        ]);
        DB::table('users')->insert([
            'id' => 4,
            'name' => 'user3',
            'username' => 'user3',
            'password' => bcrypt('123456'),
            'group_id' => 1,
            'email' => 'user3@user.com',
            'short_name' => 'user3',
            'permission' => 1
        ]);

    }
}
