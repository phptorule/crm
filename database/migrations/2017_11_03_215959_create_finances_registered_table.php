<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancesRegisteredTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finances_registered', function (Blueprint $table) {
            $table->increments('registered_id');
            $table->string('registered_finances_number')->nullable(FALSE)->default('');
            $table->string('registered_customer_name')->nullable(FALSE)->default('');
            $table->string('registered_subject')->nullable(FALSE)->default('');
            $table->string('registered_finances_netto')->nullable(FALSE)->default('');
            $table->string('registered_finances_brutto')->nullable(FALSE)->default('');
            $table->char('registered_payment_method', 1)->nullable(false)->default(0);
            $table->char('registered_paid', 1)->nullable(false)->default(0);
            $table->string('registered_issue_date', 20)->nullable(FALSE)->default('');
            $table->string('registered_payment_date', 20)->nullable(FALSE)->default('');
            $table->string('registered_assign_to')->nullable(FALSE)->default('');
            $table->integer('registered_bank_account')->unsigned()->nullable(FALSE);
            $table->string('registered_order_title')->nullable(false)->default('');
            $table->string('registered_bank_nip')->nullable(false)->default('');
            $table->string('registered_bank_name')->nullable(false)->default('');
            $table->string('registered_bank_street')->nullable(false)->default('');
            $table->string('registered_bank_town')->nullable(false)->default('');
            $table->string('registered_bank_postcode')->nullable(false)->default('');
            $table->string('registered_bank_region')->nullable(false)->default('');
            $table->string('registered_description')->nullable(false)->default('');
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
        Schema::dropIfExists('finances_registered');
    }
}
