<?php

use Illuminate\Database\Seeder;
use App\Company;
use App\Address;
use App\Truck;
use App\Device;
use App\ContainerType;
use App\Container;
use App\User;
use App\Role;
class TestContainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = factory(Company::class,15)->create()->each(function ($company){
            $address = factory(Address::class)->create();
            $company->address_id = $address->id;
            $company->save();
            //factory(Truck::class,mt_rand(2,5))->create(['company_id' => $company->id]);
            factory(Container::class,mt_rand(20,30))->create(['company_id' => $company->id])->each(function ($container){
                $device = factory(Device::class)->create(['container_id' => $container->id]);
                $container_type = factory(ContainerType::class)->create(['company_id' => $container->company_id]);
                $container->original_container_type_id = $container_type->id;
                $container->device_id = $device->id;
                $container->save();
            });
            // factory(User::class,mt_rand(1,5))->create(['company_id' => $company->id])->each(function ($user){
            //     $user->roles()->attach(Role::all()->splice(4)->random());
            // });

        });
    }
}
