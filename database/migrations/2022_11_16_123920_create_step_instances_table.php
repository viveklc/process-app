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
        Schema::create('step_instances', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedInteger('org_id')->nullable()->index();
            $table->string('org_name')->nullable();
            $table->unsignedInteger('dept_id')->nullable()->index();
            $table->string('dept_name')->nullable();
            $table->unsignedInteger('team_id')->nullable()->index();
            $table->string('team_name')->nullable();
            $table->unsignedInteger('process_id')->nullable()->index();
            $table->string('process_name')->nullable();
            $table->unsignedInteger('process_instances_id')->nullable()->index();
            $table->string('process_instance_name')->nullable();
            $table->unsignedInteger('step_id')->nullable()->index();
            $table->string('step_name')->nullable();
            $table->unsignedInteger('sequence')->nullable();
            $table->unsignedInteger('before_step_instance_id')->nullable();
            $table->unsignedInteger('after_step_instance_id')->nullable();
            $table->integer('is_substep')->nullable()->comment('1[YES] 2[NO]');
            $table->unsignedInteger('has_attachments')->nullable()->index();
            $table->unsignedInteger('has_comments')->nullable()->index();
            $table->integer('is_mandatory')->nullable()->comment('1[YES] 2[NO]');
            $table->unsignedInteger('is_child_of_step_id')->index()->nullable();
            $table->bigInteger('planned_total_duration')->nullable();
            $table->timestamp('planned_start_on')->nullable();
            $table->timestamp('planned_finish_on')->nullable();
            $table->timestamp('actual_start_on')->nullable();
            $table->timestamp('actual_finish_on')->nullable();
            $table->bigInteger('actual_total_duration')->nullable();
            $table->unsignedInteger('assigned_to_user_id')->nullable()->index();
            $table->unsignedInteger('completed_by_user_id')->nullable()->index();
            $table->integer('status')->nullable()->comment('1 [scheduled] 2[in-progress] 3[complete]');
            $table->integer('is_active')->default('1')->comment('1[Active] 2[Inactive] 3[Deleted]');
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
        Schema::dropIfExists('step_instances');
    }
};
