<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainersTable extends Migration
{
    
    public function up()
    { 
               
        Schema::create('container_types', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name', 45);
            $table->text('description')->nullable()->default(null);
            $table->uuid('company_id')->nullable()->default(null);
            $table->decimal('width', 8, 3)->default(0.0);
            $table->decimal('length', 8, 3)->default(0.0);
            $table->decimal('height', 8, 3)->default(0.0);
            $table->decimal('bulk', 8, 3)->default(0.0);
            $table->decimal('weight', 8, 3)->default(0.0);
            $table->decimal('carrying_capacity', 8, 3)->default(0.0);
            $table->boolean('traceable')->default(false);
            $table->timestamps();
            
            $table->primary('id');
            
            $table->foreign('company_id')->references('id')->on('companies');
        });
        
        Schema::create('materials', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->text('description');
            
            $table->primary('id');
        });
        
        Schema::create('containers', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('serial', 45)->nullable()->default(null)->unique();
            $table->string('name', 45);
            $table->uuid('original_container_type_id')->nullable()->default(null);
            $table->uuid('container_type_id')->nullable()->default(null);
            $table->uuid('company_id')->nullable()->default(null);
            $table->uuid('company_service_id')->nullable()->default(null);
            
            $table->uuid('material_id')->nullable()->default(null);
            $table->integer('full')->default(0);
            $table->boolean('is_empty')->default(false);
            $table->boolean('is_defect')->default(false);
            $table->boolean('is_outofservice')->default(false);
            
            $table->timestamps();
            $table->softDeletes();	
        
            $table->primary('id');
            
            $table->foreign('original_container_type_id')->references('id')->on('container_types');
            $table->foreign('container_type_id')->references('id')->on('container_types');
            $table->foreign('material_id')->references('id')->on('materials');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('company_service_id')->references('id')->on('companies');
            
        });
    }

    public function down()
    { 
        Schema::dropIfExists('containers');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('container_types');
    }
}
