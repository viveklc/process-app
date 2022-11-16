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
        Schema::create('steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('org_id')->index()->nullable();
            $table->unsignedBigInteger('dept_id')->index()->nullable();
            $table->unsignedBigInteger('team_id')->index()->nullable();
            $table->unsignedBigInteger('process_id')->index()->nullable();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->integer('sequence')->nullable();
            $table->integer('before_step_id')->nullable();
            $table->integer('after_step_id')->nullable();
            $table->integer('is_substep')->nullable()->comment('1[Yes] 2[No]');
            $table->integer('substep_of_step_id')->nullable();
            $table->integer('has_attachments')->nullable()->comment('1[Yes] 2[No]');
            $table->integer('is_mandatory')->nullable()->comment('1[Yes] 2[No]');
            $table->integer('is_conditional')->nullable()->comment('1[Yes] 2[No]');
            $table->integer('total_duration')->nullable();
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
        Schema::dropIfExists('steps');
    }
};
