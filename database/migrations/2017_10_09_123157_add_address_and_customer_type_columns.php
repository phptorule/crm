<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressAndCustomerTypeColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->char('customer_type', 1)->after('contact_person')->nullable(false)->default(0);
            $table->string('invoice_street')->nullable(false)->default('');
            $table->string('invoice_mailbox')->nullable(false)->default('');
            $table->string('invoice_town')->nullable(false)->default('');
            $table->string('invoice_province')->nullable(false)->default('');
            $table->string('invoice_post_code')->nullable(false)->default('');
            $table->string('invoice_region')->nullable(false)->default('');
            $table->string('send_street')->nullable(false)->default('');
            $table->string('send_mailbox')->nullable(false)->default('');
            $table->string('send_town')->nullable(false)->default('');
            $table->string('send_province')->nullable(false)->default('');
            $table->string('send_post_code')->nullable(false)->default('');
            $table->string('send_region')->nullable(false)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('customer_type');
            $table->dropColumn('invoice_street');
            $table->dropColumn('invoice_mailbox');
            $table->dropColumn('invoice_town');
            $table->dropColumn('invoice_province');
            $table->dropColumn('invoice_post_code');
            $table->dropColumn('invoice_region');
            $table->dropColumn('send_street');
            $table->dropColumn('send_mailbox');
            $table->dropColumn('send_town');
            $table->dropColumn('send_province');
            $table->dropColumn('send_post_code');
            $table->dropColumn('send_region');
        });
    }
}
