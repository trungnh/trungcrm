<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTaiKhoanTableAddUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tai_khoan', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tai_khoan', function (Blueprint $table) {
            $table->dropForeign('user_id');
        });
    }
}
