<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submenu', function (Blueprint $table) {
            $table->increments('id_submenu');
            $table->integer('menu_id')->length(3)->index();
            $table->integer('menu_utama_id')->length(3)->index();
            $table->string('nama_submenu', 20);
            $table->string('url_submenu', 20);
            $table->string('ikon_submenu', 50);
            $table->integer('status_submenu')->length(1);
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
        Schema::dropIfExists('submenu');
    }
}
