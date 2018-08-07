<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'user_group_id' => 1,
        'email' => $faker->unique()->safeEmail,
        'permission' => 0,
        'username' => $faker->userName,
        'short_name' => $faker->lastName,
        'phone' => '0123456789',
        'img' => '.jpg',

    ];
});
