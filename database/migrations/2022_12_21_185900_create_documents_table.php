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
        Schema::connection('mysql2')->create('documents', function (Blueprint $table) {
            $table->id();
            $table->text('document_title')->nullable();
            $table->longText('document_subtitle')->nullable();
            $table->longText('document_summary')->nullable();
            $table->string('document_type')->nullable();
            $table->string('document_version_number')->nullable();
            $table->string('document_status')->nullable();
            $table->timestamp('date_of_publication')->nullable();
            $table->unsignedBigInteger('project_id')->index();
            $table->integer('document_upvote_count')->nullable();
            $table->integer('document_downvote_count')->nullable();
            $table->string('document_thumbnail_url')->nullable();
            $table->string('document_url')->nullable();
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
        Schema::dropIfExists('documents');
    }
};
