<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('street', 100);
            $table->string('number', 20)->nullable()->default(null);
            $table->string('complement', 20)->nullable()->default(null);
            $table->string('zipcode', 10)->nullable()->default(null);
            $table->integer('city_id')->unsigned();
            $table->text('landmark')->nullable()->default(null);
            
            $table->primary('id');

            $table->foreign('city_id')->references('id')->on('cities');
        });
        
    }

    
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
