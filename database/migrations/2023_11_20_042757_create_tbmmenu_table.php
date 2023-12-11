<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbmmenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbmmenu', function (Blueprint $table) {
            $table->id('menuid')->autoIncrement();
            $table->string('parent', 100)->nullable();
            $table->string('menu', 100)->nullable();
            $table->string('url', 100)->nullable();
            $table->smallInteger('urutan')->nullable();
            $table->boolean('ishide')->nullable();
            $table->smallInteger('jenis')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbmmenu');
    }
}
