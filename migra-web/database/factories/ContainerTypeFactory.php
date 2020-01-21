<?php

use Faker\Generator as Faker;

$factory->define(App\ContainerType::class, function (Faker $faker) {
    return [
        'name' => 'Modelo ' .  $faker->randomNumber($nbDigits = 2, $strict = false),
        'description' => $faker->text($maxNbChars = 100),
        'company_id' => function () {
            return App\Company::all()->random()->id;
        },
        'width' => $faker->randomNumber($nbDigits = 3, $strict = false),
        'length' => $faker->randomNumber($nbDigits = 3, $strict = false),
        'height' => $faker->randomNumber($nbDigits = 3, $strict = false)
    ];
});
