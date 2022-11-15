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
        Schema::create('lms_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name')->nullable();
            $table->string('event_display_name')->nullable();
            $table->string('publisher_name')->nullable();
            $table->unsignedBigInteger('publisher_id')->index()->nullable();
            $table->string('publisher_type')->nullable();
            $table->string('object_name')->nullable();
            $table->unsignedBigInteger('object_id')->index()->nullable();
            $table->string('object_type')->nullable();
            $table->unsignedBigInteger('aggregate_id')->index()->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('lms_events');
    }
};
