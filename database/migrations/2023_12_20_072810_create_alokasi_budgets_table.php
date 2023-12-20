<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlokasiBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbalokasibudget', function (Blueprint $table) {
            $table->id('alokasibudgetid');
            $table->foreignId('budgetid');
            $table->string('judul');
            $table->string('alokasibudget');
            $table->date('tglalokasibudget');
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
        Schema::dropIfExists('tbalokasibudget');
    }
}
