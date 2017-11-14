<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_manager', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parent_task')->nullable(false)->default('');
            $table->string('name')->unique()->nullable(false)->default('');
            $table->string('user_id')->nullable(false)->default('');
            $table->string('text')->nullable(false)->default('');
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
        Schema::dropIfExists('task_manager');
    }

}
