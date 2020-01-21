<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->uuid('company_id')->nullable()->default(null);
            $table->double('density', 10, 2)->after('company_id')->default(0);
            $table->softDeletes();	
            $table->timestamps();	

            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materials', function (Blueprint $table){
            $table->dropForeign(['company_id']);
            $table->dropColumn(['company_id','density']);
        });
    }
}
