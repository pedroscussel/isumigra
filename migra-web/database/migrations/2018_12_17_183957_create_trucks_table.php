<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrucksTable extends Migration
{
    
    public function up()
    {        
        Schema::create('trucks', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('license_plate', 8)->unique();
            $table->string('name');
            $table->uuid('company_id')->nullable()->default(null);
            $table->boolean('is_defect')->default(false);
            $table->boolean('is_outofservice')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
            $table->primary('id');
            $table->foreign('company_id')->references('id')->on('companies');
            
        });

    }

    
    public function down()
    {
        Schema::dropIfExists('trucks');
    }
}
