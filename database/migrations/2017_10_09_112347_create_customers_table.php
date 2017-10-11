<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name')->nullable(FALSE)->default('');
            $table->string('contact_person')->nullable(FALSE)->default('');
            $table->string('assign_to')->nullable(FALSE)->default('');
            $table->integer('phone_number')->nullable(FALSE)->unsigned()->default(0);
            $table->integer('extra_phone_number')->nullable(FALSE)->unsigned()->default(0);
            $table->integer('bank_account')->nullable(FALSE)->unsigned()->default(0);
            $table->string('nip')->nullable(FALSE)->default('');
            $table->string('email')->nullable(FALSE)->default('');
            $table->string('extra_email')->nullable(FALSE)->default('');
            $table->string('website')->nullable(FALSE)->default('');
            $table->string('fb_link')->nullable(FALSE)->default('');
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
        Schema::dropIfExists('customers');
    }
}
