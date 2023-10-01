<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('nip');
            $table->string('name', 200);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('jns_kelamin', 10)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('alamat', 200)->nullable();
            $table->string('jabatan', 50)->nullable();
            $table->string('golongan', 50)->nullable();
            $table->integer('sisa_ct')->default(12);
            $table->date('tgl_msk')->nullable();
            // 0 = pegawai; 1 = kadiv; 2 = pimpinan;
            $table->tinyInteger('role')->default(0);
            $table->string('lama_krja', 10)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
