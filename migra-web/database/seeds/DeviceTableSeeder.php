<?php

use Illuminate\Database\Seeder;
use App\ModelDevice;

class DeviceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelDevice::create([
            'name' => 'Model 1',
            'version' => '0.1',
            'description' => "Modelo em desenvolvimento. Utilizado para testes de desenvolvimento"
        ]);
    }
}
