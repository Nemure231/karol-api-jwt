<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAksesMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akses_role', function (Blueprint $table) {
            $table->increments('id_akses_role');
            $table->integer('menu_id')->length('3')->index();
            $table->integer('role_id')->length('3')->index();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akses_menu');
    }
}
