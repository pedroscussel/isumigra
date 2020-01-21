<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{

    public function up()
    {


        Schema::create('devices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 45)->nullable()->default(null)->unique();

            // From device
            $table->bigInteger('mass_1')->default(0);
            $table->bigInteger('mass_2')->default(0);
            $table->bigInteger('mass_3')->default(0);
            $table->bigInteger('mass_4')->default(0);
            $table->unsignedBigInteger('ntc')->default(0);
            $table->string('gps')->nullable()->default(null);
            $table->unsignedBigInteger('bat')->default(0);
            $table->float('latitude')->default(0);
            $table->float('longitude')->default(0);
            $table->float('volume')->default(0);

            // Values
            $table->boolean('battery_charging')->default(false);

            $table->uuid('container_id')->nullable()->default(null);
            $table->boolean('is_defect')->default(false);
            $table->boolean('is_outofservice')->default(false);

            $table->timestamps();
            $table->softDeletes();


            $table->foreign('container_id')->references('id')->on('containers');
        });

        Schema::table('containers', function(Blueprint $table){

            $table->unsignedBigInteger('device_id')->nullable()->default(null)->after('company_id');
            $table->foreign('device_id')->references('id')->on('devices');
        });
    }

    public function down()
    {
        Schema::table('containers', function(Blueprint $table){
            $table->dropForeign(['device_id']);
            $table->dropColumn(['device_id']);
        });

        Schema::dropIfExists('devices');
    }
}
