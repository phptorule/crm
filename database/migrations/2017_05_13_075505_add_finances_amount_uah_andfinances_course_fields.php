<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFinancesAmountUahAndfinancesCourseFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finances', function (Blueprint $table) {
            $table->double('finances_amount_uah', 8, 2)->nullable(false)->after('finances_amount')->default('0.00');
            $table->double('finances_course', 6, 2)->nullable(false)->after('finances_amount_uah')->default('1.00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finances', function (Blueprint $table) {
            $table->dropColumn('finances_amount_uah');
            $table->dropColumn('finances_course');
        });
    }
}
