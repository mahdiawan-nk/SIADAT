<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformasiBudayasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informasi_budayas', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('jenis', ['seni_tari', 'seni_musik', 'kuliner_khas', 'peninggalan']);
            $table->string('nama')->nullable();
            $table->string('jenis_peninggalan')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('ringkasan');
            $table->string('foto');
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
        Schema::dropIfExists('informasi_budayas');
    }
}
