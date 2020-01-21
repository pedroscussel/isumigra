<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(CountriesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(CompanyTypesTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(DeviceTableSeeder::class);
        $this->call(MaterialSeeder::class);
        // $this->call(TestSeeder::class);
        // $this->call(TestContainerSeeder::class);

    }
}
