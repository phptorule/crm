<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->increments('finances_id');
            $table->string('finances_customer_name')->nullable(FALSE)->default('');
            $table->char('finances_payment_method', 1)->nullable(false)->default(0);
            $table->char('finances_paid', 1)->nullable(false)->default(0);
            $table->string('finances_issue_date', 20)->nullable(FALSE)->default('');
            $table->string('finances_payment_date', 20)->nullable(FALSE)->default('');
            $table->string('finances_assign_to')->nullable(FALSE)->default('');
            $table->integer('finances_products_id')->unsigned()->nullable(FALSE);
            $table->string('finances_invoice_street')->nullable(false)->default('');
            $table->string('finances_invoice_mailbox')->nullable(false)->default('');
            $table->string('finances_invoice_town')->nullable(false)->default('');
            $table->string('finances_invoice_province')->nullable(false)->default('');
            $table->string('finances_invoice_post_code')->nullable(false)->default('');
            $table->string('finances_invoice_region')->nullable(false)->default('');
            $table->string('finances_send_street')->nullable(false)->default('');
            $table->string('finances_send_mailbox')->nullable(false)->default('');
            $table->string('finances_send_town')->nullable(false)->default('');
            $table->string('finances_send_province')->nullable(false)->default('');
            $table->string('finances_send_post_code')->nullable(false)->default('');
            $table->string('finances_send_region')->nullable(false)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finances');
    }
}
