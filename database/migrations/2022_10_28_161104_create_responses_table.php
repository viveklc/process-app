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
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id')->index()->nullable();
            $table->text('response_text')->nullable();
            $table->string('response_asset_url')->nullable();
            $table->string('response_asset_type')->nullable();
            $table->integer('is_correct')->nullable()->comment('1[correct] 2[in correct]');
            $table->integer('is_conditional')->nullable()->comment('1[yes] 2[no]');
            $table->unsignedBigInteger('conditional_question_id')->index()->nullable();
            $table->string('sequence')->nullable();
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
        Schema::dropIfExists('responses');
    }
};
