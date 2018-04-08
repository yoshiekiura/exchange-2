<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true);
            $table->integer('payment_system_id', false, true);
            $table->integer('currency_id', false, true);
            $table->string('wallet_number');
            $table->string('wallet_type')->default('user');
            $table->timestamps();

            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('payment_system_id')->references('id')->on('payment_systems');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('wallets', function (Blueprint $table) {
		    $table->dropForeign('wallets_user_id_foreign');
		    $table->dropForeign('wallets_payment_system_id_foreign');
		    $table->dropForeign('wallets_currency_id_foreign');
	    });

        Schema::dropIfExists('wallets');
    }
}
