<?php

use Illuminate\Database\Seeder;
use App\Company;
use App\City;
use App\Address;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $city = City::where('name',"Farroupilha")->first();
  
        // MIGRA
        $company = Company::create([
            'name' => 'Equipamentos Para Movimentacao Migra Ltda',
            'trading_name' => 'Migra',
            'cnpj' => '25.400.600/0001-78',
            'company_type_id' => 1,
        ]);
        
        $address = new Address();
        $address->street = "Rodovia RS 122";
        $address->number = "km 54";
        $address->city()->associate($city);
        $address->save();
    
        $company->address_id = $address->id;
        $company->owner_id = $company->id;
        $company->save();
       

        $company = Company::create([
            'name' => 'Tecnova Preparação De Materiais Ltda',
            'trading_name' => 'Tecnova',
            'cnpj' => '08.038.972/0001-87',
            'company_type_id' => 2,
        ]);
        $company->owner_id = Company::where('trading_name','Migra')->first()->id;
        
        $address = new Address();
        $address->street = "Travessa Milanês";
        $address->complement = "Nova Milano";
        $address->city()->associate($city);
        $address->save();
    
        $company->address_id = $address->id;
        $company->save();
    }
}
