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
        Schema::create('process_instances', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('org_id')->nullable()->index();
            $table->unsignedInteger('dept_id')->nullable()->index();
            $table->unsignedInteger('team_id')->nullable()->index();
            $table->unsignedInteger('process_id')->nullable()->index();
            $table->string('process_instance_name')->nullable();
            $table->longText('process_description')->nullable();
            $table->integer('process_priority')->nullable()->comment('1[hight] 2 [low] 3[medium]');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->integer('total_duration')->nullable();
            $table->timestamp('actual_enddate')->nullable();
            $table->integer('actual_duration')->nullable();
            $table->unsignedInteger('assigned_to_user_id')->nullable()->index();
            $table->string('status')->nullable()->comment('[added] [rejected] [published]');
            $table->integer('is_active')->default('1')->comment('1[Active] 2[Inactive] 3[Deleted]');
            $table->integer('status')->nullable()->comment('1[added] 2[rejected] 3[published]');
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
        Schema::dropIfExists('process_instances');
    }
};
