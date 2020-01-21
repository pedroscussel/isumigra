<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('model_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('version');
            $table->text('description')->nullable()->default(null);
            $table->timestamps();
        });
        
        Schema::table('devices', function(Blueprint $table){
            $table->unsignedInteger('model_device_id')
                    ->nullable()->default(null)->after('name');
            $table->foreign('model_device_id')->references('id')->on('model_devices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devices', function(Blueprint $table){
            $table->dropForeign(['model_device_id']);
            $table->dropColumn(['model_device_id']);
        });
        Schema::dropIfExists('model_devices');
    }
}
