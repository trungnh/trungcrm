<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('month')->nullable();
            $table->double('return_rate')->nullable();
            $table->decimal('shipping_rate')->nullable();
            $table->decimal('product_unit_price')->nullable();
            $table->double('ads_tax_rate')->default(0);
            $table->double('ads_payment_fee')->default(0);
            $table->double('tax_rate')->default(0);
            $table->string('source')->nullable();
            $table->text('items')->nullable();
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
        Schema::dropIfExists('report');
    }
}
