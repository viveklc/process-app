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
        Schema::create('details', function (Blueprint $table) {
            $table->id();
            $table->string('sourceable_type')->nullable()->comment('[course, level, subject, book, chapter, page, activity, game]');
            $table->unsignedBigInteger('sourceable_id')
            ->index('DetailSource_20221017114814')
            ->nullable()
            ->comment('[category id, course id]');
            $table->text('detail_keyname')->nullable()->comment('[course-duration, course-cost, category-logo]');
            $table->text('detail_keyvalue')->nullable()->comment('[5, 400]');
            $table->text('detail_keyvalueunit')->nullable()->comment('[months, days, rupees]');
            $table->text('tags')->nullable()->comment('comma separated tag text');
            $table->text('tag_ids')->nullable()->comment('comma separated tag ids
            both are here but maybe only one will be used. this is for flexibility');
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
        Schema::dropIfExists('details');
    }
};
