<?php

use Faker\Generator as Faker;

$factory->define(App\Container::class, function (Faker $faker) {
    $serial = $faker->randomNumber($nbDigits = 6, $strict = false);
    
    return [
        'serial' => $serial,
        'name' => $serial,
        // 'company_id' => function () {
        //     return App\Company::all()->random()->id;
        // },
        // 'container_type_id' => function () {
        //     return App\ContainerType::all()->random()->id ;
        // },
        
    ];
});
