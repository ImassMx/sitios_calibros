<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCedulaToDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['liga_id']);
            $table->dropColumn('liga_id');
            $table->string('cedula')->after('folio')->nullable();
            $table->uuid('uuid')->after('cedula');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('cedula');
            $table->dropColumn('uuid');
            $table->foreignId('liga_id')->nullable()->constrained('ligas');
        });
    }
}
