<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('acaras', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('image')->nullable();
            $table->date('tanggal_acara');
            $table->date('batas_pendaftaran');
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->unsignedBigInteger('panitia_id');
            $table->foreign('panitia_id')->references('id')->on('panitia')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('acaras');
    }
};