<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnInCheckboxesUsersTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checkboxes_users', function (Blueprint $table) {
            $table->renameColumn('checklists_id', 'checkboxes_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checkboxes_users', function (Blueprint $table) {
            $table->renameColumn('checkboxes_id', 'checklists_id');
        });
    }
}
