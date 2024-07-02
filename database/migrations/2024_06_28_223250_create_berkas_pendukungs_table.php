<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBerkasPendukungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berkas_pendukungs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_ninik_mamak');
            $table->string('nama_berkas');
            $table->string('file');
            $table->timestamps();

            $table->foreign('id_ninik_mamak')->references('id')->on('datouk_ninik_mamaks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('berkas_pendukungs');
    }
}
