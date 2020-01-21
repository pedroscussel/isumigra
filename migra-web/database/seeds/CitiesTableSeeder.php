<?php

use Illuminate\Database\Seeder;
use PragmaRX\Countries\Package\Countries;
use App\Country;
use App\State;
use App\City;

class CitiesTableSeeder extends Seeder
{

    public function run()
    {
        ini_set('memory_limit', '-1');
        DB::statement("SET foreign_key_checks=0");
        City::truncate();
        $this->addStates("Brazil");
        $this->otherCities();
    }
    
    protected function addStates($name)
    {
        $country = Country::where('common', $name)->first();
        foreach ($country->states as $state) {
            $this->addCities($name, $state);
        }
    }
    
    protected function addCities($country, $state)
    {

        $cities = Countries::where('name.common', $country)
                ->first()
                ->hydrateCities()
                ->cities->where('adm1name', $state->name);

        $cs = array();
        foreach ($cities as $c) {
            $cs[] = ['name' => utf8_decode($c->name), 'state_id' => $state->id];
        }

        City::insert($cs);
    }
    
    protected function otherCities()
    {
        $rs = State::where('name', 'Rio Grande do Sul')->first();
        City::insert([
            ['name' => 'Farroupilha', 'state_id' => $rs->id]
        ]);
    }
}
