<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePluginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins', function (Blueprint $table) {
            $table->increments('plugins_id');
            $table->string('plugins_name')->nullable(FALSE)->default('');
            $table->string('plugins_code')->nullable(FALSE)->default('');
            $table->double('plugins_price', 6, 2)->nullable(FALSE)->default('0.00');
            $table->text('plugins_config')->nullable(FALSE);
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
        Schema::dropIfExists('plugins');
    }
}
