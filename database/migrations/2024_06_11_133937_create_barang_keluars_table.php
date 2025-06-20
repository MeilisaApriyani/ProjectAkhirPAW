<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_keluars', function (Blueprint $table) {
            $table->bigIncrements('idkeluar');
            $table->string('idbarang');
            $table->string('namabarang');
            $table->string('keterangan');
            $table->integer('jumlahkeluar');
            $table->timestamp('tanggalkeluar')->useCurrent();;
            $table->string('image')->nullable();
            $table->timestamps();
            $table->foreign('idbarang')->references('idbarang')->on('stocks')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('barang_keluars');
    }
};
