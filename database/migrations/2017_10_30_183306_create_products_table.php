<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('products_id');
            $table->char('products_type', 1)->nullable(false)->default(0);
            $table->string('products_name')->nullable(FALSE)->default('');
            $table->integer('products_amount')->unsigned()->nullable(FALSE);
            $table->string('products_dimension')->nullable(FALSE)->default('');
            $table->integer('products_cost')->unsigned()->nullable(FALSE);
            $table->integer('products_vat_percent')->unsigned()->nullable(FALSE);
            $table->integer('products_vat_amount')->unsigned()->nullable(FALSE);
            $table->integer('products_total_cost')->unsigned()->nullable(FALSE);
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
        Schema::dropIfExists('products');
    }
}
