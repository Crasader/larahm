<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('type_id');
            $table->dateTime('deposit_date')->default('2017-01-01 00:00:00');
            $table->dateTime('last_pay_date')->default('2017-01-01 00:00:00');
            $table->enum('status', ['on', 'off'])->nullable()->default('on');
            $table->integer('q_pays');
            $table->double('amount', 10, 5)->default(0.00000);
            $table->double('actual_amount', 10, 5)->default(0.00000);
            $table->integer('ec');
            $table->float('compound', 10, 5)->nullable();
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
        Schema::dropIfExists('deposits');
    }
}