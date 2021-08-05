<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_soal')->unsigned()->nullable(true);
            $table->foreign('id_soal')->references('id')->on('soals');
            $table->bigInteger('id_jawaban')->unsigned()->nullable(true);
            $table->foreign('id_jawaban')->references('id')->on('jawabans');
            $table->bigInteger('id_siswa')->unsigned()->nullable(true);
            $table->foreign('id_siswa')->references('id')->on('users');
            $table->integer('nilai')->nullable(true);
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
        Schema::dropIfExists('nilais');
    }
}
