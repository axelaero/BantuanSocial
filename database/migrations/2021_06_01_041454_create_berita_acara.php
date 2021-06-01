<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritaAcara extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berita_acara', function (Blueprint $table) {
            $table->integer('ba_id')->unique();
            $table->integer('kelurahan_id');
            $table->string('periode');
            $table->integer('total_usulan');
            $table->integer('total_perbaikan');
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
        Schema::dropIfExists('berita_acara');
    }
}
