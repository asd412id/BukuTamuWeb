<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableGuest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->string('telp')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('tujuan')->nullable();
            $table->json('anggota')->nullable();
            $table->datetime('cin')->nullable();
            $table->datetime('cout')->nullable();
            $table->bigInteger('instansi_id');
            $table->string('_token');
            $table->tinyInteger('rating')->nullable();
            $table->text('kesan')->nullable();
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
        Schema::dropIfExists('guest');
    }
}
