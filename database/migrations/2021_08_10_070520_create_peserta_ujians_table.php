<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaUjiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta_ujians', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_paket')->unsigned()->nullable(true);
            $table->foreign('id_paket')->references('id')->on('pakets');
            $table->bigInteger('id_siswa')->unsigned()->nullable(true);
            $table->foreign('id_siswa')->references('id')->on('users');
            $table->dateTime('waktu_mulai')->nullable(true);
            $table->dateTime('waktu_selesai')->nullable(true);
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
        Schema::dropIfExists('peserta_ujians');
    }
}
