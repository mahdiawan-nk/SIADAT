<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatoukNinikMamaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datouk_ninik_mamaks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('gelar');
            $table->string('alamat');
            $table->unsignedInteger('id_kenegerian');
            $table->string('suku');
            $table->unsignedInteger('id_user');
            $table->integer('status')->default(0);
            $table->json('catatan')->nullable();
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
        Schema::dropIfExists('datouk_ninik_mamaks');
    }
}
