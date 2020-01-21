<?php

use Illuminate\Database\Seeder;
use App\CompanyType;

class CompanyTypesTableSeeder extends Seeder
{
    public function run()
    {
        CompanyType::insert([
            ['name' => "Migra"],
            ['name' => "Cliente"],
            ['name' => "Gerador"],
            ['name' => "Terceiro"],
            
        ]);        
    }
}
