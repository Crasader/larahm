<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export.
 *
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 250)->nullable();
            $table->text('description')->nullable();
            $table->integer('q_days')->nullable();
            $table->float('min_deposit', 10, 2)->nullable();
            $table->float('max_deposit', 10, 2)->nullable();
            $table->enum('period', ['d', 'w', 'b-w', 'm', '2m', '3m', '6m', 'y', 'end'])->nullable();
            $table->enum('status', ['on', 'off', 'suspended'])->nullable();
            $table->enum('return_profit', ['0', '1'])->nullable();
            $table->float('return_profit_percent', 10, 2)->nullable();
            $table->float('percent', 10, 2)->nullable();
            $table->integer('pay_to_egold_directly');
            $table->integer('use_compound');
            $table->integer('work_week');
            $table->integer('parent');
            $table->unsignedTinyInteger('withdraw_principal');
            $table->double('withdraw_principal_percent', 10, 2)->default(0.00);
            $table->unsignedInteger('withdraw_principal_duration');
            $table->double('compound_min_deposit', 10, 2)->nullable()->default(0.00);
            $table->double('compound_max_deposit', 10, 2)->nullable()->default(0.00);
            $table->unsignedTinyInteger('compound_percents_type')->nullable();
            $table->double('compound_min_percent', 10, 2)->nullable()->default(0.00);
            $table->double('compound_max_percent', 10, 2)->nullable()->default(100.00);
            $table->text('compound_percents')->nullable();
            $table->unsignedTinyInteger('closed');
            $table->unsignedInteger('withdraw_principal_duration_max');
            $table->text('dsc')->nullable();
            $table->integer('hold');
            $table->integer('delay');
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
        Schema::dropIfExists('types');
    }
}
