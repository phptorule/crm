<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFinancesTotalAmountColumnToFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finances', function (Blueprint $table) {
            $table->float('finances_total_amount', 6, 2)->after('finances_paid')->unsigned()->nullable(FALSE);
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
            $table->dropColumn('finances_total_amount');
        });
    }
}
