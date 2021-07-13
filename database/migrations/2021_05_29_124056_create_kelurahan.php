<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelurahan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelurahan', function (Blueprint $table) {
            $table->integer('kelurahan_id')->unique();
            $table->string('kelurahan_nama')->unique();
            $table->string('kelurahan_alamat');
            $table->string('kelurahan_telepon');
            $table->string('kelurahan_kodepos');
            $table->string('kecamatan_nama');
            $table->string('jumlah_rw');
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
        Schema::dropIfExists('kelurahan');
    }
}
