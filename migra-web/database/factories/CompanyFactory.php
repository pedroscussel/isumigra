<?php

use Faker\Generator as Faker;

$factory->define(App\Company::class, function (Faker $faker) {
    $name = $faker->company;
    $trading_name = explode(" ", $name)[0];
    
    return [
        'name' => $name,
        'trading_name' => $trading_name,
        'cnpj' => $faker->randomNumber($nbDigits = 6, $strict = false),
        'owner_id' => function () {
            return App\Company::all()->random()->id;
        },
        'company_type_id' => function () {
            return App\CompanyType::all()->random()->id;
        },
    
    ];
});
