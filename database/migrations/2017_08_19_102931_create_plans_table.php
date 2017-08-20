<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export.
 *
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 250)->nullable();
            $table->text('description')->nullable();
            $table->float('min_deposit', 10, 2)->nullable();
            $table->float('max_deposit', 10, 2)->nullable();
            $table->float('percent', 10, 2)->nullable();
            $table->enum('status', ['on', 'off'])->nullable();
            $table->integer('parent');
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
        Schema::dropIfExists('plans');
    }
}
