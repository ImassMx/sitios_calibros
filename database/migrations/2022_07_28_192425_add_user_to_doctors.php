<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserToDoctors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('doctors')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->integer('user_id')->nullable();
                $table->string('cp')->nullable();
                $table->date('fecha_descarga')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('cp');
            $table->dropColumn('user_id');
            $table->dropColumn('fecha_descarga');
        });
    }
}
