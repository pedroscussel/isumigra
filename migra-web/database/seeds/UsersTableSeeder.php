<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Company;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //MIGRA

        $company = Company::where('trading_name','Migra')->first();

        $user = new User();
        $user->name  = "Administrador Migra";
        $user->email = 'admin@migra.ind.br';
        $user->password = bcrypt('admin');
        $user->company()->associate($company);
        $user->save();
        $user->roles()->attach(Role::rootAdminPermission()->first());

        //Cliente

        $company = Company::where('trading_name','Tecnova')->first();

        $user = new User();
        $user->name  = "Administrador Tecnova";
        $user->email = 'admin@tecnova.ind.br';
        $user->password = bcrypt('admin');
        $user->company()->associate($company);
        $user->save();
        $user->roles()->attach(Role::adminPermission()->first());

    }
}
