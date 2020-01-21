<?php

use Faker\Generator as Faker;

$factory->define(App\ServiceOrder::class, function (Faker $faker) {
    $company = App\Company::all()->random();
    return [
        'number' => $company->num_services,
        'material_id' => App\Material::all()->random()->id,
        'quantity' => $faker->randomNumber($nbDigits = 1, $strict = false),
        'address_src_id' => App\Company::all()->random()->address_id,
        'address_des_id' => App\Company::all()->random()->address_id,
        'container_type_id' => App\ContainerType::all()->random()->id,
        'company_id' => App\Company::all()->random()->id,
        'container_id' => App\Container::all()->random()->id,
        'truck_id' => App\Truck::all()->random()->id,
        'user_id' => App\User::all()->random()->id,
        'owner_id' =>$company->id,
    ];
});
