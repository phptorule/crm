<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiscountAndTaxColumnToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->float('products_discount_percent', 6, 2)->after('products_cost')->unsigned()->nullable(FALSE);
            $table->float('products_discount_regular', 6, 2)->after('products_discount_percent')->unsigned()->nullable(FALSE);
            $table->float('products_shipping_price', 6, 2)->after('products_vat_percent')->unsigned()->nullable(FALSE);
            $table->float('products_vat_shipping_percent', 6, 2)->after('products_shipping_price')->unsigned()->nullable(FALSE);
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
            $table->dropColumn('products_discount_percent');
            $table->dropColumn('products_discount_regular');
            $table->dropColumn('products_shipping_price');
            $table->dropColumn('products_vat_shipping_percent');
        });
    }
}
