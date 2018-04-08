<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationsExchangeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::table('exchange_requests', function (Blueprint $table) {
			$table->foreign('currency_from')->references('id')->on('currencies')->onDelete('set null');
			$table->foreign('currency_to')->references('id')->on('currencies')->onDelete('set null');

			$table->foreign('payment_system_from')->references('id')->on('payment_systems')->onDelete('set null');
			$table->foreign('payment_system_to')->references('id')->on('payment_systems')->onDelete('set null');

			$table->foreign('transaction_type')->references('id')->on('transaction_types')->onDelete('set null');
			$table->foreign('payment_type')->references('id')->on('payment_types')->onDelete('set null');
			$table->foreign('request_type')->references('id')->on('request_types')->onDelete('set null');
			$table->foreign('status_id')->references('id')->on('statuses')->onDelete('set null');
			$table->foreign('pay_to_service_status')->references('id')->on('statuses')->onDelete('set null');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			$table->foreign('wallet_from')->references('id')->on('wallets')->onDelete('set null');
			$table->foreign('wallet_to')->references('id')->on('wallets')->onDelete('set null');
			$table->foreign('sys_wallet')->references('id')->on('wallets')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('exchange_requests', function (Blueprint $table) {
			$table->dropForeign('exchange_requests_currency_from_foreign');
			$table->dropForeign('exchange_requests_currency_to_foreign');

			$table->dropForeign('exchange_requests_payment_system_from_foreign');
			$table->dropForeign('exchange_requests_payment_system_to_foreign');

			$table->dropForeign('exchange_requests_transaction_type_foreign');
			$table->dropForeign('exchange_requests_payment_type_foreign');
			$table->dropForeign('exchange_requests_request_type_foreign');
			$table->dropForeign('exchange_requests_status_id_foreign');
			$table->dropForeign('exchange_requests_pay_to_service_status_foreign');
			$table->dropForeign('exchange_requests_user_id_foreign');

			$table->dropForeign('exchange_requests_wallet_from_foreign');
			$table->dropForeign('exchange_requests_wallet_to_foreign');
			$table->dropForeign('exchange_requests_sys_wallet_foreign');
		});
	}
}
