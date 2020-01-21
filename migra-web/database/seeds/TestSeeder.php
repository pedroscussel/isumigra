<?php

use Illuminate\Database\Seeder;
use App\Device;
use App\Container;
use App\ContainerType;
use App\Company;
use App\City;
use App\Address;
use App\User;
use App\CompanyType;
use App\Role;
use App\Truck;
use App\ServiceOrder;

class TestSeeder extends Seeder
{

    public function run()
    {


        $city = City::where('name',"Farroupilha")->first();

        $user = new User();
        $user->name  = "Operador Migra";
        $user->email = 'ope@migra.ind.br';
        $user->password = bcrypt('operator');
        $user->company_id = Company::where('trading_name','Migra')->first()->id;
        $user->save();
        $user->roles()->attach(Role::rootPermission('operator')->first());

        $user = new User();
        $user->name  = "Gerente Migra";
        $user->email = 'manager@migra.ind.br';
        $user->password = bcrypt('gerente');
        $user->company_id = Company::where('trading_name','Migra')->first()->id;
        $user->save();
        $user->roles()->attach(Role::rootPermission('manager')->first());

        $user = new User();
        $user->name  = "Comercial Migra";
        $user->email = 'comercial@migra.ind.br';
        $user->password = bcrypt('comercial');
        $user->company_id = Company::where('trading_name','Migra')->first()->id;
        $user->save();
        $user->roles()->attach(Role::rootPermission('business')->first());

        $container_type = new ContainerType();
        $container_type->name ="Modelo Migra";
        $container_type->description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sagittis pulvinar mattis. In lectus lectus.";
        $container_type->company_id = Company::where('trading_name','Migra')->first()->id;
        $container_type->save();

        // Tecnova Test
        $tecnova = Company::where('trading_name','Tecnova')->first();
        $tecnoUsers = [
           ['name' => 'Operator Tecnova', 'email' => 'ope@tecnova.ind.br', 'password' => bcrypt('123456'), 'company_id' => $tecnova->id],
           ['name' => 'Diretor Tecnova',  'email' => 'dir@tecnova.ind.br', 'password' => bcrypt('123456'), 'company_id' => $tecnova->id],
           ['name' => 'Comercial Tecnova', 'email' => 'com@tecnova.ind.br', 'password' => bcrypt('123456'), 'company_id' => $tecnova->id]
        ];
        foreach($tecnoUsers as $u) {
            User::create($u);
        }
        User::where('email','ope@tecnova.ind.br')->first()->roles()->attach(Role::permission('operator')->first());
        User::where('email','dir@tecnova.ind.br')->first()->roles()->attach(Role::permission('manager')->first());
        User::where('email','com@tecnova.ind.br')->first()->roles()->attach(Role::permission('business')->first());

        $container_type = new ContainerType();
        $container_type->name ="Modelo Tecnova";
        $container_type->description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sagittis pulvinar mattis. In lectus lectus.";
        $container_type->company_id = Company::where('trading_name','Tecnova')->first()->id;
        $container_type->save();

        $company = new Company();

        $company->name = 'Empresa cliente Tecnova';
        $company->trading_name = 'ECliente';
        $company->cnpj = '00.000.000/0000-01';
        $company->company_type_id = 2;
        $company->owner_id = $tecnova->id;

        $address = new Address();
        $address->street = "Rua D";
        $address->number = "1";
        $address->city()->associate($city);
        $address->save();
        $company->address_id = $address->id;
        $company->save();

        $user = new User();
        $user->name  = "Cliente Tecnova";
        $user->email = 'cli@tecnova.ind.br';
        $user->password = bcrypt('123456');
        $user->company_id = $company->id;
        $user->save();
        $user->roles()->attach(Role::permission('generator')->first());

        /*
        $container = new Container();
        $container->name = $container->serial = '31';
        $container->originalType()->associate(ContainerType::all()->first());
        $container->company()->associate($company);
        $container->company_service_id = $company->id;
        $container->save();

        $device = new Device();
        $device->volume = 0;
        $device->latitude = -27.070613;
        $device->longitude = -52.044809;
        $device->container()->associate($container);
        $device->save();
        $container->device_id = $device->id;
        $container->company_service_id = $company->id;
        $container->save();
        */


//////////////////////////////////////////////////////////////////////

        $company = new Company();

        $company->name = 'Empresa Ficitícia B Ltda.';
        $company->trading_name = 'Ficitícia B';
        $company->cnpj = '00.000.000/0000-11';
        $company->company_type_id = 2;
        $company->owner_id = Company::where('trading_name','Migra')->first()->id;

        $address = new Address();
        $address->street = "Rua A";
        $address->number = "1";
        $address->city()->associate($city);
        $address->save();
        $company->address_id = $address->id;
        $company->save();

        $user = new User();
        $user->name  = "Admin Ficitícia B";
        $user->email = 'admin@b.com';
        $user->password = bcrypt('admin');
        $user->company()->associate($company);
        $user->save();
        $user->roles()->attach(Role::adminPermission()->first());

        $user = new User();
        $user->name  = "Comercial Ficitícia B";
        $user->email = 'comercial@b.com';
        $user->password = bcrypt('comercial');
        $user->company()->associate($company);
        $user->save();
        $user->roles()->attach(Role::permission('business')->first());

        $user = new User();
        $user->name  = "Operador Ficitícia B";
        $user->email = 'op@b.com';
        $user->password = bcrypt('operador');
        $user->company()->associate($company);
        $user->save();
        $user->roles()->attach(Role::permission('operator')->first());

        $container = new Container();
        $container->name = $container->serial = '11';
        $container->originalType()->associate(ContainerType::all()->first());
        $container->company()->associate($company);
        $container->company_service_id = $company->id;
        $container->save();

        $device = new Device();
        $device->volume = 0;
        $device->latitude = -28.070613;
        $device->longitude = -53.044809;
        $device->container()->associate($container);
        $device->save();
        $container->device_id = $device->id;
        $container->company_service_id = $company->id;
        $container->save();

        $container = new Container();
        $container->name = $container->serial = '12';
        $container->originalType()->associate(ContainerType::all()->first());
        $container->company()->associate($company);
        $container->company_service_id = $company->id;
        $container->save();

        $device = new Device();
        $device->volume = 0.2;
        $device->latitude = -28.367690;
        $device->longitude = -53.955930;
        $device->container()->associate($container);
        $device->save();
        $container->device_id = $device->id;
        $container->company_service_id = $company->id;
        $container->save();

        $container = new Container();
        $container->name = $container->serial = '13';
        $container->originalType()->associate(ContainerType::all()->last());
        $container->company()->associate($company);
        $container->company_service_id = $company->id;
        $container->save();

        $device = new Device();
        $device->volume = 0.9;
        $device->latitude = -29.663186;
        $device->longitude = -52.434650;
        $device->container()->associate($container);
        $device->save();
        $container->device_id = $device->id;
        $container->company_service_id = $company->id;
        $container->save();

        $truck = new Truck();
        $truck->name = '1';
        $truck->license_plate = 'ABC1234';
        $truck->company_id = $company->id;
        $truck->save();

        $truck = new Truck();
        $truck->name = '2';
        $truck->license_plate = 'ABC2134';
        $truck->company_id = $company->id;
        $truck->save();

///////////////////////////////////////////////////////////////////////////////////////////////////

        $company = new Company();

        $company->name = 'Empresa Fictícia A Ltda.';
        $company->trading_name = 'Fictícia A';
        $company->cnpj = '00.000.000/0000-02';
        $company->company_type_id = 2;
        $company->owner_id = Company::where('trading_name','Migra')->first()->id;


        $address = new Address();
        $address->street = "Rua B";
        $address->number = "2";
        $address->city()->associate($city);
        $address->save();
        $company->address_id = $address->id;
        $company->save();

        $user = new User();
        $user->name  = "Admin Fictícia A";
        $user->email = 'admin@a.com';
        $user->password = bcrypt('admin');
        $user->company()->associate($company);
        $user->save();
        $user->roles()->attach(Role::adminPermission()->first());

        $user = new User();
        $user->name  = "Comercial Fictícia A";
        $user->email = 'comercial@a.com';
        $user->password = bcrypt('comercial');
        $user->company()->associate($company);
        $user->save();
        $user->roles()->attach(Role::permission('business')->first());

        $user = new User();
        $user->name  = "Operador Fictícia A";
        $user->email = 'op@a.com';
        $user->password = bcrypt('operador');
        $user->company()->associate($company);
        $user->save();
        $user->roles()->attach(Role::permission('operator')->first());



        $container = new Container();
        $container->name = $container->serial = '14';
        $container->originalType()->associate(ContainerType::all()->last());
        $container->company()->associate($company);
        $container->company_service_id = $company->id;
        $container->save();

        $device = new Device();
        $device->volume = 0.45;
        $device->latitude = -29.697573;
        $device->longitude = -51.132805;
        $device->container()->associate($container);
        $device->save();
        $container->device_id = $device->id;
        $container->company_service_id = $company->id;
        $container->save();

        $container = new Container();
        $container->name = $container->serial = '15';
        $container->originalType()->associate(ContainerType::all()->last());
        $container->company()->associate($company);
        $container->company_service_id = $company->id;
        $container->save();

        $device = new Device();
        $device->volume = 0.66;
        $device->latitude = -29.280831;
        $device->longitude = -51.334500;
        $device->container()->associate($container);
        $device->save();
        $container->device_id = $device->id;
        $container->company_service_id = $company->id;
        $container->save();

        $container = new Container();
        $container->name = $container->serial = '16';
        $container->originalType()->associate(ContainerType::all()->first());
        $container->company()->associate($company);
        $container->company_service_id = $company->id;
        $container->save();

        $device = new Device();
        $device->volume = 0.8;
        $device->latitude = -30.013867;
        $device->longitude = -50.155423;
        $device->container()->associate($container);
        $device->save();
        $container->device_id = $device->id;
        $container->company_service_id = $company->id;
        $container->save();

        $truck = new Truck();
        $truck->name = '3';
        $truck->license_plate = 'ABC3214';
        $truck->company_id = $company->id;
        $truck->save();

        $truck = new Truck();
        $truck->name = '4';
        $truck->license_plate = 'ABC1324';
        $truck->company_id = $company->id;
        $truck->save();

        ////////////////////////////////////////////////////////////////////////////
        $company = new Company();

        $company->name = 'Empresa geradora Ltda.';
        $company->trading_name = 'geradora';
        $company->cnpj = '00.000.000/0000-04';
        $company->company_type_id = 3;
        $company->owner_id = Company::where('trading_name','Fictícia A')->first()->id;


        $address = new Address();
        $address->street = "Rua C";
        $address->number = "3";
        $address->city()->associate($city);
        $address->save();
        $company->address_id = $address->id;
        $company->save();

        $user = new User();
        $user->name  = "Gerador";
        $user->email = 'gerador@geradora.com';
        $user->password = bcrypt('gerador');
        $user->company_id = Company::where('trading_name','geradora')->first()->id;
        $user->save();
        $user->roles()->attach(Role::permission('generator')->first());


        // factory(ServiceOrder::class,180)->create();

    }
}
