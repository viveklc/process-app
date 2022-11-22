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
        Schema::create('process_events', function (Blueprint $table) {
            $table->id();
            $table->string('process_event_name')->nullable();
            $table->string('publisher_name')->nullable();
            $table->string('publisher_type')->nullable();
            $table->string('object_name')->nullable();
            $table->unsignedInteger('object_id')->nullable()->index();
            $table->string('object_type')->nullable()->index();
            $table->unsignedInteger('aggregation_id')->nullable()->index();
            $table->string('aggregation_type')->nullable()->index();
            $table->longText('remarks')->nullable();
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
        Schema::dropIfExists('process_events');
    }
};
