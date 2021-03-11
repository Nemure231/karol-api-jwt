<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahKolomUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
        
            $table->integer('telepon')->length('20')->after('password');
            $table->text('alamat')->after('telepon');
            $table->string('gambar', 200)->after('alamat');
            $table->integer('role_id')->length('10')->after('gambar');
            $table->integer('status')->length('1')->after('role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
