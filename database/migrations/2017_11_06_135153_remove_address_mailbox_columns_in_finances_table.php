<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveAddressMailboxColumnsInFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finances', function (Blueprint $table) {
            $table->dropColumn('finances_invoice_mailbox');
            $table->dropColumn('finances_send_mailbox');
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
            $table->string('finances_invoice_mailbox')->nullable(false)->default('');
            $table->string('finances_send_mailbox')->nullable(false)->default('');
        });
    }
}
