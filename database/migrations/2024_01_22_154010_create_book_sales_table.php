<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_sales', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name');
            $table->string('image');
            $table->foreignId('category_id')->constrained('categories');
            $table->string('author');
            $table->text('description');
            $table->decimal('price',10,2);
            $table->integer('points');
            $table->boolean('active');
            $table->integer('downloads')->default(0);
            $table->string('pdf');
            $table->softDeletes();
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
        Schema::dropIfExists('book_sales');
    }
}
