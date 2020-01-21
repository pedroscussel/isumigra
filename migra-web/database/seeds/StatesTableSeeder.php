<?php

use Illuminate\Database\Seeder;
use PragmaRX\Countries\Package\Countries;
use App\Country;
use App\State;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addStates("Brazil");           
    }
    
    protected function addStates($name) {
        $country = Country::where('common', $name)->first();
        
        
        $states = Countries::where('name.common', $country->common)
                ->first()
                ->hydrateStates()
                ->states
                ->sortBy('name');
           
        foreach($states as $s) {
            $state = new State(['name' => $s->name, 'abbreviation' =>  $s->postal]);
            $country->states()->save($state);
        }        
    }
}
