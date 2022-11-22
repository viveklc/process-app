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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('attachment_name')->nullable();
            $table->longText('attachment_description')->nullable();
            $table->integer('attachment_type')->nullable()->comment('1[audio] 2[video] 3[image] 4[link]');
            $table->string('attachment_url')->nullable();
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
            $table->unsignedInteger('uploaded_by_user_id')->nullable()->index();
            $table->integer('status')->nullable()->comment('1[uploaded] 2[linked]');
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
        Schema::dropIfExists('attachments');
    }
};
