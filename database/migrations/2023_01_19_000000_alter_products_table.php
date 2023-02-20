<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('keyword')->nullable();
            $table->decimal('unit_price')->nullable();
            $table->decimal('shipping_price')->nullable();
            $table->double('return_rate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('keyword');
            $table->dropColumn('unit_price');
            $table->dropColumn('shipping_price');
            $table->dropColumn('return_rate');
        });
    }
}
