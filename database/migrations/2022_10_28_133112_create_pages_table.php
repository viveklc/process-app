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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chapter_id')
            ->index()
            ->nullable();
            $table->text('page_type')->nullable()->comment('will be used to determine how to render page
            can be content, audio, video, composite, image, activity, game, link');
            $table->text('page_content')->nullable()->comment('will have html content');
            $table->text('page_content_url')->nullable()->comment('will be used in case the page content is to be fetched from another URL');
            $table->text('page_sequence')->nullable();
            $table->string('is_first')->nullable()
            ->comment('yes, no');
            $table->string('is_last')->nullable()
            ->comment('yes, no');
            $table->text('is_composite')->nullable()
            ->comment('will be used for future
            this will be used when one page is made up of multiple pages and json for each page has to be created and parsed based on some html tag like <p>');
            $table->unsignedBigInteger('book_id')
            ->index()
            ->nullable()
            ->comment('optional book id');
            $table->text('is_conditional')->nullable()->comment('these pages will not appear in every learning flow');
            $table->text('tags')->nullable();
            $table->integer('is_active')->default('1')->comment('1[Active] 2[Inactive] 3[Deleted]');
            $table->string('status')->nullable()->comment('1-draft, 2-submitted, 3-approved, 4-published, 5-rejected, 6-deleted, 7-archived');
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
        Schema::dropIfExists('pages');
    }
};
