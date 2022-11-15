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
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->text('image_url')->nullable()->comment('Managed by spatie media library');
            $table->unsignedBigInteger('course_id')
            ->index()
            ->nullable()
            ->comment('optional course id');
            $table->unsignedBigInteger('level_id')
            ->index()
            ->nullable()
            ->comment('optional level id');
            $table->unsignedBigInteger('subject_id')
            ->index()
            ->nullable()
            ->comment('optional subject id');
            $table->unsignedBigInteger('book_id')
            ->index()
            ->nullable()
            ->comment('optional book id');
            $table->string('sequence')->nullable();
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
        Schema::dropIfExists('chapters');
    }
};
