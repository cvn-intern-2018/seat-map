<?php

use Faker\Generator as Faker;

$factory->define(App\UserGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->words(3, true),
    ];
});
