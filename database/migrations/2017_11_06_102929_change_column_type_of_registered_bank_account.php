<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnTypeOfRegisteredBankAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finances_registered', function (Blueprint $table) {
            $table->string('registered_bank_account')->nullable(FALSE)->default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finances_registered', function (Blueprint $table) {
            $table->integer('registered_bank_account')->unsigned()->nullable(FALSE);
        });
    }
}
