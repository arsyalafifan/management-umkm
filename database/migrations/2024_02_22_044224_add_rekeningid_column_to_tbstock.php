<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRekeningidColumnToTbstock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbstockmanagement', function (Blueprint $table) {
            $table->foreignId('rekeningid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbstockmanagement', function (Blueprint $table) {
            $table->dropColumn('terealisasikan');
        });
    }
}
