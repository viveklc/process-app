<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('document_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id')->index();
            $table->string('document_keyname')->nullable();
            $table->string('document_keytype')->nullable();
            $table->string('document_keyvalue')->nullable();
            $table->integer('is_active')->default('1')->comment('1[Active] 2[Inactive] 3[Deleted]');
            $table->string('status')->nullable();
            $table->unsignedBigInteger('createdby_userid')->nullable();
            $table->unsignedBigInteger('updatedby_userid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_details');
    }
};
