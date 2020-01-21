<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->text('description')->nullable()->default(null);
            $table->string('filename')->nullable()->default(null);
            $table->string('mimetype')->nullable()->default(null);
            $table->string('extension')->nullable()->default(null);
            $table->unsignedInteger('filesize')->default(0);
            $table->string('documentable_type')->nullable()->default(null);
            $table->uuid('documentable_id')->nullable()->default(null);
            $table->timestamps();
            
            $table->primary('id');
        });
        
        Schema::create('container_type_document', function (Blueprint $table) {
            $table->uuid('container_type_id');
            $table->uuid('document_id');
            $table->timestamps();

            $table->unique(['container_type_id','document_id']);
            $table->foreign('container_type_id')->references('id')->on('container_types')->onDelete('cascade');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('container_type_document');
        Schema::dropIfExists('documents');
    }
}
