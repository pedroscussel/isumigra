<?php

use Illuminate\Database\Seeder;
use App\Material;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Material::Create([
            'name' => 'Vazio',
            'description' => 'Vazio',
            'density' => '0.1'
        ]);
        
        Material::Create([
            'name' => 'Madeira',
            'description' => 'Madeira',
            'density' => '154'
        ]);

        Material::Create([
            'name' => 'Metal',
            'description' => 'Metal',
            'density' => '483'
        ]);

        Material::Create([
            'name' => 'Papel',
            'description' => 'Papel',
            'density' => '62'
        ]);

        Material::Create([
            'name' => 'Plástico',
            'description' => 'Plástico',
            'density' => '55'
        ]);

        Material::Create([
            'name' => 'Entulho',
            'description' => 'Entulho',
            'density' => '916'
        ]);
    }
}
