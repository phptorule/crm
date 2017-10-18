<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_comments', function (Blueprint $table) {
            $table->increments('comment_id');
            $table->integer('customer_id')->unsigned()->nullable(FALSE);
            $table->integer('teams_id')->unsigned()->nullable(FALSE);
            $table->integer('user_id')->unsigned()->nullable(FALSE);
            $table->string('comment_text', 1000)->nullable(FALSE)->default('');
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
        Schema::dropIfExists('customers_comments');
    }
}
