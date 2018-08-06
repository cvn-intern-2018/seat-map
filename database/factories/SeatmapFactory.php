<?php

use Faker\Generator as Faker;

$factory->define(App\SeatMap::class, function (Faker $faker) {
    return [
        'name' => '[' . $faker->dayOfMonth . '-' . $faker->month . '-' . $faker->year . '] '
            . $faker->sentence(),
        'img' => '.png',
    ];
});
