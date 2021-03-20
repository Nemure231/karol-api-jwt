<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id_barang');
            $table->string('kode_barang', 40);
            $table->string('nama_barang', 100);
            $table->integer('kategori_id')->index();
            $table->integer('satuan_id')->index();
            $table->integer('merek_id')->index();
            $table->integer('supplier_id')->index();
            $table->double('harga_pokok');
            $table->double('harga_konsumen');
            $table->double('harga_anggota');
            $table->integer('stok_id')->index()->default(58);
            $table->integer('stok_barag');
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
        Schema::dropIfExists('barang');
    }
}













