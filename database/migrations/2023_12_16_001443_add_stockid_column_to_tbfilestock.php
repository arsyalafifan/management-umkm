<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStockidColumnToTbfilestock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbfilestock', function (Blueprint $table) {
            $table->foreignId('stockid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbfilestock', function (Blueprint $table) {
            $table->dropColumn('stockid');
        });
    }
}
