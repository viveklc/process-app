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
        Schema::create('process_recurrences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('process_id')->index()->nullable();
            $table->dateTime('has_fixed_date')->nullable();
            $table->integer('recurrence_type')->nullable();
            $table->integer('recurrence_unit')->nullable()
                ->comment('1-year, 2-month, 3-week, 4-day, 5-hours, 6-minutes, 7-sec');
            $table->integer('recurrence_value')->nullable()
                ->comment('1 here and 2 in frequency units means that the task will repeat after 1 month');
            $table->string('recurrence_day')->nullable();
            $table->integer('recurrence_time_difference')->nullable();
            $table->string('recurrence_time')->nullable();
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
        Schema::dropIfExists('process_recurrence');
    }
};
