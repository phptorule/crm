<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeamsIdColumnToFinancesRegisteredTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finances_registered', function (Blueprint $table) {
            $table->string('teams_id')->after('registered_id')->nullable(false)->default(0);
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
            $table->dropColumn('teams_id');
        });
    }
}
