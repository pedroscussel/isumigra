<?php

use Illuminate\Database\Seeder;
use PragmaRX\Countries\Package\Countries;
use App\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $countries = new Countries();
        $all = $countries->all();
        foreach($all as $c) {
            try {
                $name = $c->translations->por->common;
            }
            catch(Exception $e) {
                $name = $c->name->common;
            }
            
            Country::create(['name' => $name, 'abbreviation'=> $c->cca3,'common' => $c->name->common]);

        }
        
    }
}
