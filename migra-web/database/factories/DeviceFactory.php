<?php

use Faker\Generator as Faker;

$factory->define(App\Device::class, function (Faker $faker) {

    //avoid coordinates at sea
    $longitude = -53 + mt_rand(-30000,30000)/10000;
    $latitude = -30 + mt_rand(-30000,30000)/10000;
    while (($longitude + 24.5847)/0.855131 > $latitude)
    {
        $longitude = -53 + mt_rand(-30000,30000)/10000;
        $latitude = -30 + mt_rand(-30000,30000)/10000;
    }

    return [
        'name' => $faker->randomNumber($nbDigits = 6, $strict = false),
        'latitude' => $latitude,
        'longitude' => $longitude,
        'volume' => $faker->randomNumber($nbDigits = 2, $strict = false)/100
    ];
});
