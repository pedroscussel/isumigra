<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{

    
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('abbreviation', 3)->nullable()->default(null);
            $table->string('common')->nullable()->default(null);
        });
        
        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('abbreviation', 2)->nullable()->default(null);
            $table->unsignedInteger('country_id');
            
            $table->foreign('country_id')->references('id')->on('countries');
        });
        
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('state_id');
            
            $table->foreign('state_id')->references('id')->on('states');
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('cities');
        Schema::dropIfExists('states');
        Schema::dropIfExists('countries');
    }
}
