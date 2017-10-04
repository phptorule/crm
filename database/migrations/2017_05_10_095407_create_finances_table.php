<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->increments('finances_id');
            $table->integer('teams_id')->nullable(FALSE)->unsigned()->default(0);
            $table->integer('currency_id')->nullable(FALSE)->unsigned()->default(0);
            $table->double('finances_amount', 8, 2)->nullable(FALSE)->default('0.00');
            $table->tinyInteger('finances_type')->nullable(FALSE)->unsigned()->default(0);
            $table->string('finances_payer')->nullable(FALSE)->default('');
            $table->string('finances_desc')->nullable(FALSE)->default('');
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
        Schema::dropIfExists('finances');
    }
}
