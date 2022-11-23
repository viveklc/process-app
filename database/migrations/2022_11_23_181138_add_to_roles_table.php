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
        Schema::table('roles', function (Blueprint $table) {
            $table->integer('is_active')->default('1')->comment('1[Active] 2[Inactive] 3[Deleted]')->after('guard_name');
            $table->string('status')->nullable()->after('is_active');
            $table->unsignedBigInteger('createdby_userid')->nullable()->after('status');
            $table->unsignedBigInteger('updatedby_userid')->nullable()->after('createdby_userid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
