<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuUtamaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_utama', function (Blueprint $table) {
            $table->increments('id_menu_utama');
            $table->integer('menu_id')->length('3')->index();
            $table->string('nama_menu_utama', 20);
            $table->string('ikon_menu_utama', 50);
           
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_utama');
    }
}
