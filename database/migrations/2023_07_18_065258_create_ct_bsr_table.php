<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ct_bsr', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->date('tgl_mulai');
            $table->date('tgl_sls');
            $table->date('tgl_pgjn');
            $table->string('keterangan', 200);
            $table->integer('durasi')->nullable();
            $table->string('status')->nullable();
            $table->foreign('id_user')->references('id')->on('users') -> onDelete('cascade');
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
        Schema::dropIfExists('ct_bsr');
    }
};
