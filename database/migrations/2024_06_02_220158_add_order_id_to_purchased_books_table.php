<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderIdToPurchasedBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchased_books', function (Blueprint $table) {
            $table->string('order_id')->after('donwloads')->nullable();
            $table->decimal('price',8,2)->after('order_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchased_books', function (Blueprint $table) {
            $table->dropColumn('order_id');
            $table->dropColumn('price');
        });
    }
}
