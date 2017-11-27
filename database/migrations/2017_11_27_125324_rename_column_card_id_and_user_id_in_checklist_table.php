<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnCardIdAndUserIdInChecklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checklist', function (Blueprint $table) {
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
        Schema::table('checklist', function (Blueprint $table) {
            $table->renameColumn('cards_id', 'card_id');
            $table->renameColumn('users_id', 'user_id');
        });
    }
}
