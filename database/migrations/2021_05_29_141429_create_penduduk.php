<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenduduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->integer('penduduk_nik'); //TIDAK UNIQUE KARENA ORANG DAPAT DAFTAR > 1 KALI
            $table->integer('penduduk_kk');
            $table->integer('penduduk_id_bdt')->nullable(); //sudah dapat bantuan atau belum nya
            $table->string('penduduk_nama');
            $table->string('penduduk_alamat');
            $table->integer('penduduk_status')->nullable();
            $table->string('penduduk_deskripsi');
            $table->string('periode'); //FORMAT Q<iterasi> <tahun>
            $table->integer('kelurahan_id');
            $table->integer('approved_status')->nullable();
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
        Schema::dropIfExists('penduduk');
    }
}
