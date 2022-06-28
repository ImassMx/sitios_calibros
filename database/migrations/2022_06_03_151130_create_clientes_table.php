<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('nombre_doctor');
            $table->string('folio');
            $table->string('codigo_postal');
            $table->string('alcaldia');
            $table->string('ciudad');
            $table->string('estado');
            $table->foreignId('libro_id')->nullable()->constrained();
            $table->date('fecha_descarga')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
