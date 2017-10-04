<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeamsInviteAndTeamsApprovedFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_teams', function (Blueprint $table) {
            $table->tinyInteger('teams_invite')->nullable(false)->after('teams_leader')->default('0');
            $table->tinyInteger('teams_approved')->nullable(false)->after('teams_invite')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_teams', function (Blueprint $table) {
            $table->dropColumn('teams_invite');
            $table->dropColumn('teams_approved');
        });
    }
}
