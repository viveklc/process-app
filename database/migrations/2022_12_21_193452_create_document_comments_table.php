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
        Schema::connection('mysql2')->create('document_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('document_id')->index();
            $table->text('comment_text')->nullable();
            $table->unsignedBigInteger('in_reply_to_comment_id')->index();
            $table->unsignedBigInteger('is_from_author')->index();
            $table->unsignedBigInteger('is_from_instructor')->index();
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
        Schema::dropIfExists('document_comments');
    }
};
