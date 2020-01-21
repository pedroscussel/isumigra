<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrdersTable extends Migration
{
    
    public function up()
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('num_service');
            $table->uuid('material_id')->nullable()->default(null);
            $table->string('material_real')->nullable()->default(null);
            $table->string('quantity')->nullaable()->default(null);
            $table->string('quantity_real')->nullable()->default(null);
            $table->uuid('address_src_id');
            $table->uuid('address_des_id');
            $table->uuid('container_type_id')->nullable()->default(null);
            $table->uuid('company_id');
            $table->uuid('container_id')->nullable()->default(null);
            $table->uuid('truck_id')->nullable()->default(null);
            $table->uuid('user_id')->nullable()->default(null);
            $table->uuid('owner_id')->nullable()->default(null);
            $table->timestamps();

            $table->primary('id');
            
            $table->foreign('address_src_id')->references('id')->on('addresses');
            $table->foreign('address_des_id')->references('id')->on('addresses');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('container_id')->references('id')->on('containers');
            $table->foreign('truck_id')->references('id')->on('trucks');
            $table->foreign('container_type_id')->references('id')->on('container_types');
            $table->foreign('user_id')->references('id')->on('users');   
            $table->foreign('owner_id')->references('id')->on('companies');
        });
        
        Schema::table('containers', function(Blueprint $table) {
            $table->uuid('service_order_id')->nullable()->default(null)->after('company_service_id');
            $table->foreign('service_order_id')->references('id')->on('service_orders');
        });
        
    }

    
    public function down()
    {
        Schema::table('containers', function(Blueprint $table) {
            $table->dropForeign(['service_order_id']);
            $table->dropColumn(['service_order_id']);
        });
        
        Schema::dropIfExists('service_orders');
    }
}
