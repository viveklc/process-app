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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('org_id')->nullable()->index();
            $table->string('name')->nullable();
            $table->string('username')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('is_org_admin')->default(2)->comment('1[YES] 2[NO]');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
