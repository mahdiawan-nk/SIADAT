<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('percakapan_id');
            $table->unsignedInteger('id_user_sender');
            $table->unsignedInteger('id_user_recieve');
            $table->text('isi_pesan');
            $table->string('attachment')->nullable();
            $table->timestamps();
            
            $table->foreign('id_user_sender')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_user_recieve')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesans');
    }
}
