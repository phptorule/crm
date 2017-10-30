<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeamsFieldsToTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->string('teams_phone', 20)->after('teams_name')->nullable(FALSE)->default('');
            $table->string('teams_extra_phone', 20)->after('teams_phone')->nullable(FALSE)->default('');
            $table->string('teams_email')->after('teams_extra_phone')->nullable(FALSE)->default('');
            $table->string('teams_extra_email')->after('teams_email')->nullable(FALSE)->default('');
            $table->string('teams_nip')->after('teams_extra_email')->nullable(FALSE)->default('');
            $table->string('teams_bank_name', 20)->after('teams_nip')->nullable(FALSE)->default('');
            $table->string('teams_bank_account', 30)->after('teams_bank_name')->nullable(FALSE)->default('');
            $table->string('teams_website')->after('teams_bank_account')->nullable(FALSE)->default('');
            $table->string('teams_fb_link')->after('teams_website')->nullable(FALSE)->default('');
            $table->string('teams_invoice_street')->after('teams_fb_link')->nullable(false)->default('');
            $table->string('teams_invoice_mailbox')->after('teams_invoice_street')->nullable(false)->default('');
            $table->string('teams_invoice_town')->after('teams_invoice_mailbox')->nullable(false)->default('');
            $table->string('teams_invoice_province')->after('teams_invoice_town')->nullable(false)->default('');
            $table->string('teams_invoice_postcode')->after('teams_invoice_province')->nullable(false)->default('');
            $table->string('teams_invoice_region')->after('teams_invoice_postcode')->nullable(false)->default('');
            $table->string('teams_send_street')->after('teams_invoice_region')->nullable(false)->default('');
            $table->string('teams_send_mailbox')->after('teams_send_street')->nullable(false)->default('');
            $table->string('teams_send_town')->after('teams_send_mailbox')->nullable(false)->default('');
            $table->string('teams_send_province')->after('teams_send_town')->nullable(false)->default('');
            $table->string('teams_send_post_code')->after('teams_send_province')->nullable(false)->default('');
            $table->string('teams_send_region')->after('teams_send_post_code')->nullable(false)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        chema::table('teams', function (Blueprint $table) {
            $table->dropColumn('teams_phone');
            $table->dropColumn('teams_extra_phone');
            $table->dropColumn('teams_email');
            $table->dropColumn('teams_extra_email');
            $table->dropColumn('teams_nip');
            $table->dropColumn('teams_bank_name');
            $table->dropColumn('teams_bank_account');
            $table->dropColumn('teams_website');
            $table->dropColumn('teams_fb_link');
            $table->dropColumn('teams_invoice_street');
            $table->dropColumn('teams_invoice_mailbox');
            $table->dropColumn('teams_invoice_town');
            $table->dropColumn('teams_invoice_province');
            $table->dropColumn('teams_invoice_postcode');
            $table->dropColumn('teams_invoice_region');
            $table->dropColumn('teams_send_street');
            $table->dropColumn('teams_send_mailbox');
            $table->dropColumn('teams_send_town');
            $table->dropColumn('teams_send_province');
            $table->dropColumn('teams_send_post_code');
            $table->dropColumn('teams_send_region');
        });
    }
}
