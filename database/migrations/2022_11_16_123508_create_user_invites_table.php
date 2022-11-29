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
        Schema::create('user_invites', function (Blueprint $table) {
            $table->id();
            $table->string('invitee_email')->nullable();
            $table->string('invitee_name')->nullable();
            $table->foreignId('invited_by_user_id')->nullable()->index();
            $table->foreignId('invite_for_org_id')->nullable()->index();
            $table->foreignId('invite_for_dept_id')->nullable()->index();
            $table->foreignId('invite_for_team_id')->nullable()->index();
            $table->string('invite_code')->nullable();
            $table->integer('invite_status')->default(1)->comment('1[pending] 2 [approved]');
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
        Schema::dropIfExists('user_invites');
    }
};
