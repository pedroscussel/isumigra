<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    
    public function up()
    {
        Schema::create('company_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
        
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name', 100);
            $table->string('trading_name', 100);
            $table->string('cnpj', 18);
            $table->uuid('address_id')->nullable()->default(null);
            $table->unsignedInteger('company_type_id')->nullable()->default(null);
            $table->uuid('owner_id')->nullable()->default(null);
            $table->unsignedInteger('num_services')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->primary('id');
            
            $table->unique('cnpj', 'owner_id');
            
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreign('company_type_id')->references('id')->on('company_types');
            $table->foreign('owner_id')->references('id')->on('companies');
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
        Schema::dropIfExists('company_types');
    }
}
