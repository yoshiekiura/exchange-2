<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyPaymentSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_payment_system', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('currency_id', false, true);
            $table->integer('payment_system_id', false, true);
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('payment_system_id')->references('id')->on('payment_systems')->onDelete('cascade');
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
	    Schema::table('currency_payment_system', function (Blueprint $table) {
		    $table->dropForeign('currency_payment_system_currency_id_foreign');
		    $table->dropForeign('currency_payment_system_payment_system_id_foreign');
	    });

        Schema::dropIfExists('currency_payment_system');
    }
}
