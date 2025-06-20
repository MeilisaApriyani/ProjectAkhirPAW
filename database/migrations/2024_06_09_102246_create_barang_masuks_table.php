<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangMasuksTable extends Migration
{
    public function up()
    {
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->bigIncrements('idmasuk');
            $table->string('idbarang');
            $table->string('namabarang');
            $table->string('penanggungjawab');
            $table->integer('jumlahmasuk');
            $table->timestamp('tanggalMasuk')->useCurrent();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->foreign('idbarang')->references('idbarang')->on('stocks')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang_masuks');
    }
}

