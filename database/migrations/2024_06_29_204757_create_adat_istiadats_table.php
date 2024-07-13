<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdatIstiadatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adat_istiadats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_adat');
            $table->unsignedInteger('id_kenegerian');
            $table->json('catatan')->nullable();
            $table->string('foto');
            $table->string('lokasi');
            $table->integer('status');
            $table->unsignedInteger('id_user');
            $table->timestamps();
            $table->foreign('id_kenegerian')->references('id')->on('kenegerians')->onDelete('restrict');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adat_istiadats');
    }
}
