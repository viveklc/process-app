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
        Schema::create('user_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_quiz_id')->index()->nullable();
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->unsignedBigInteger('quiz_id')->index()->nullable();
            $table->unsignedBigInteger('question_id')->index()->nullable();
            $table->text('question_text')->nullable();
            $table->unsignedBigInteger('response_id')->index()->nullable();
            $table->text('response_text')->nullable();
            $table->unsignedBigInteger('confidence_level')->nullable();
            $table->integer('is_correct')->nullable()->comment('1[correct] 2[in correct]');
            $table->integer('score')->nullable();
            $table->dateTime('date_time')->nullable();
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
        Schema::dropIfExists('user_responses');
    }
};
