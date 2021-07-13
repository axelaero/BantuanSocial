<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelasiPendudukBa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relasi_penduduk_ba', function (Blueprint $table) {
            $table->integer('relasi_id');
            $table->integer('penduduk_id');  //penduduk id, bukan nik
            $table->integer('ba_id');   //berita acara id
            $table->integer('cek_dinas');
            $table->integer('cek_mentri');
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
        Schema::dropIfExists('relasi_penduduk_ba');
    }
}
