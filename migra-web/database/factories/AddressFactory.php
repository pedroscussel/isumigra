<?php

use Faker\Generator as Faker;

$factory->define(App\Address::class, function (Faker $faker) {
    return [
        'street' => $faker->streetName,
        'number' => $faker->randomNumber($nbDigits = 4, $strict = false),
        'city_id' => function (){
            return App\City::all()->random()->id;
        },
    ];
});
