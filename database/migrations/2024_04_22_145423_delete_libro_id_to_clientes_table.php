<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteLibroIdToClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign(['libro_id']);
            $table->dropColumn('libro_id');
            $table->dropColumn('alcaldia');
            $table->dropColumn('ciudad');
            $table->dropColumn('estado');
            $table->dropColumn('fecha_descarga');
            $table->dropColumn('descargas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Eliminar los registros que no cumplen con la restricción de clave externa
        DB::table('clientes')->whereNotNull('libro_id')->whereNotExists(function ($query) {
            $query->select(DB::raw(1))->from('libros')->whereRaw('clientes.libro_id = libros.id');
        })->delete();

        // Luego, vuelves a agregar la restricción de clave externa
        Schema::table('clientes', function (Blueprint $table) {
            $table->foreign('libro_id')->references('id')->on('libros');
            $table->string('alcaldia');
            $table->string('ciudad');
            $table->string('estado');
            $table->date('fecha_descarga')->nullable();
            $table->integer("descargas")->default(0);
        });
    }
}
