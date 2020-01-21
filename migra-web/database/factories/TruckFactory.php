<?php

use Faker\Generator as Faker;

$factory->define(App\Truck::class, function (Faker $faker) {
    $letters = $faker->randomLetter . $faker->randomLetter . $faker->randomLetter; 
    $license_plate = $faker->toUpper($letters) . $faker->randomNumber(4);
    return [
        'license_plate' => $license_plate,
        'name' => $faker->randomNumber(4)
    ];
});
