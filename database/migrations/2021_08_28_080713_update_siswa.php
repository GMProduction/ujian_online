<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn('kelas');

        });

        Schema::table('siswas', function (Blueprint $table) {
            $table->bigInteger('kelas')->unsigned()->nullable(true);
            $table->foreign('kelas')->references('id')->on('kelas');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
