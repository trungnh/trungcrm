<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBmTableAddAdaIgnoreIds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bm', function (Blueprint $table) {
            $table->string('ignored_ada_ids')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bm', function (Blueprint $table) {
            $table->dropForeign('ignored_ada_ids');
        });
    }
}
