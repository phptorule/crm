<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDecisionColumnsToCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->string('case_number')->after('done')->default('');
            $table->string('decision_done')->after('case_number')->default('');
            $table->string('decision_approve')->after('decision_done')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn('case_number')->after('done')->default('');
            $table->dropColumn('decision_done')->after('case_number')->default('');
            $table->dropColumn('decision_approve')->after('decision_done')->default('');
        });
    }
}
