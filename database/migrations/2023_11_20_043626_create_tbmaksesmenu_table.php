<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbmaksesmenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbmaksesmenu', function (Blueprint $table) {
            $table->id('aksesmenuid');
            $table->foreignId('aksesid')->nullable();
            $table->foreignId('menuid')->nullable();
            $table->boolean('tambah')->nullable();
            $table->boolean('ubah')->nullable();
            $table->boolean('hapus')->nullable();
            $table->boolean('lihat')->nullable();
            $table->boolean('cetak')->nullable();
            $table->string('opadd', 50)->nullable();
            $table->string('pcadd', 20)->nullable();
            $table->timestamp('tgladd');
            $table->string('opedit', 50)->nullable();
            $table->string('pcedit', 20)->nullable();
            $table->timestamp('tgledit');
            $table->boolean('dlt')->default('0')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbmaksesmenu');
    }
}
