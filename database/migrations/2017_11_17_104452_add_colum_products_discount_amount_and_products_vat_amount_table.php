<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumProductsDiscountAmountAndProductsVatAmountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('products_discount_amount')->after('products_discount_regular')->nullable(FALSE)->default('0');
            //$table->string('products_vat_amount')->after('products_discount_amount')->nullable(FALSE)->default('0');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('products_discount_amount');
            //$table->dropColumn('products_vat_amount');
        });
    }
}




