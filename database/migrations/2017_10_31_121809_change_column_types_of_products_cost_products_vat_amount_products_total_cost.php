<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnTypesOfProductsCostProductsVatAmountProductsTotalCost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->float('products_cost', 6, 2)->unsigned()->nullable(FALSE)->change();
            $table->float('products_vat_amount', 6, 2)->unsigned()->nullable(FALSE)->change();
            $table->float('products_total_cost', 6, 2)->unsigned()->nullable(FALSE)->change();
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
            $table->integer('products_cost')->unsigned()->nullable(FALSE);
            $table->integer('products_vat_amount')->unsigned()->nullable(FALSE);
            $table->integer('products_total_cost')->unsigned()->nullable(FALSE);
        });
    }
}
