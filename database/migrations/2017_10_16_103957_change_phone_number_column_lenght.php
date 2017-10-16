<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePhoneNumberColumnLenght extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('phone_number', 20)->nullable(FALSE)->unsigned()->default(0)->change();
            $table->string('extra_phone_number', 20)->nullable(FALSE)->unsigned()->default(0)->change();
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
            $table->integer('phone_number')->nullable(FALSE)->unsigned()->default(0);
            $table->integer('extra_phone_number')->nullable(FALSE)->unsigned()->default(0);
        });
    }
}
