<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnOnCardsIdAndUsersIdInCardsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cards_users', function (Blueprint $table) {
            $table->renameColumn('card_id', 'cards_id');
            $table->renameColumn('user_id', 'users_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cards_users', function (Blueprint $table) {
            $table->renameColumn('cards_id', 'cards_id');
            $table->renameColumn('users_id', 'user_id');
        });
    }
}
