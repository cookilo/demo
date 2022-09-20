<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNecessaryColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('post_code', false,true)->nullable();
            $table->string('address')->nullable();
            $table->longText('contract')->nullable();
            $table->mediumText('proficiency')->nullable();
            $table->unsignedInteger('salary')->nullable();
            $table->date('date_of_birth')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('post_code');
            $table->dropColumn('address');
            $table->dropColumn('contract');
            $table->dropColumn('proficiency');
            $table->dropColumn('salary');
            $table->dropColumn('date_of_birth');
        });
    }
}
