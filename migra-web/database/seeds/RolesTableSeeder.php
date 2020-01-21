<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{

    public function run()
    {
        // Users MIGRA
        Role::Create(
            [
                'name' => 'Administrador do Sistema (Migra)',
                'slug' => 'migra_admin',
                'permissions' => ['admin' => true, 'migra' => true]
            ]
        );

        Role::Create(
            [
                'name' => 'Direção (Migra)', 'slug' => 'migra_manager',
                'permissions' => ['manager' => true, 'migra' => true, 'admin' => false]
            ]
        );

        Role::Create(
            [
                'name' => 'Comercial (Migra)', 'slug' => 'migra_business',
                'permissions' => ['business' => true, 'migra' => true, 'admin' => false]]
        );

        Role::Create(
            [
                'name' => 'Operador (Migra)', 'slug' => 'migra_operator',
                'permissions' => ['operator' => true, 'migra' => true, 'admin' => false]
            ]
        );

        // User not migra
        Role::Create(
            [
                'name' => 'Administrador ', 'slug' => 'admin',
                'permissions' => ['admin' => true, 'migra' => false]
            ]
        );

        Role::Create(
            [
                'name' => 'Gerencia', 'slug' => 'manager',
                'permissions' => ['manager' => true, 'admin' => false, 'migra' => false]
            ]
        );

        Role::Create(
            [
                'name' => 'Comercial', 'slug' => 'business',
                'permissions' => ['business' => true, 'admin' => false, 'migra' => false]
            ]
        );

        Role::Create(
            [
                'name' => 'Operador', 'slug' => 'operator',
                'permissions' => ['operator' => true, 'admin' => false, 'migra' => false]
            ]
        );

        Role::Create(
            [
                'name' => 'Gerador', 'slug' => 'generator',
                'permissions' => ['generator' => true, 'admin' => false, 'migra' => false]
            ]
        );



    }
}
