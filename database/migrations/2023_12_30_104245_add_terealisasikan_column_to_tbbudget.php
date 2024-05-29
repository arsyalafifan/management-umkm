<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTerealisasikanColumnToTbbudget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbbudget', function (Blueprint $table) {
            $table->double('terealisasikan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbbudget', function (Blueprint $table) {
            $table->dropColumn('terealisasikan');
        });
    }
}
