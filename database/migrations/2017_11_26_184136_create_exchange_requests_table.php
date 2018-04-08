<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_requests', function (Blueprint $table) {
            $table->increments('id');
	        $table->text('exchange_number')->comment('Номер заявки');
	        $table->integer('user_id', false, true)->comment('Пользователь');
	        $table->integer('request_id')->default(0)->comment('Заявка для которой создан етот ответ')->nullable();
	        $table->integer('payment_system_from', false, true)->comment('С платежной системы')->nullable();
	        $table->integer('payment_system_to', false, true)->comment('К платежной системе')->nullable();
	        $table->integer('currency_from', false, true)->comment('Хочу обменять валюту')->nullable();
	        $table->integer('currency_to', false, true)->comment('Хочу получить валюту')->nullable();
	        $table->decimal('amount_from',19,8)->default(0)->comment('Сумма которую пользователь отдает');
	        $table->decimal('amount_to',19,8)->default(0)->comment('Сумма которую пользователь хочет получить');
	        $table->decimal('amount_get', 19, 8)->cooment('Сумма которую получит пользователь с учётом коммиссии');
	        $table->integer('wallet_from', false, true)->nullable()->comment('Кошелек с которого осуществляется обмен');
	        $table->integer('wallet_to', false, true)->nullable()->comment('Кошелек на который должен поступить результат обмена');
	        $table->integer('sys_wallet', false, true)->nullable()->comment('Системный кошелек для оплаты');
	        $table->decimal('rate',19, 8)->comment('Курс ведущей валюты по ЦБРФ (USD,EUR,RUB)');
	        $table->decimal('commission', 19, 8)->comment('Коммиссия сервиса');
	        $table->integer('transaction_type', false, true)->nullable()->comment('Тип транзакции');
	        $table->integer('payment_type', false, true)->nullable()->comment('Способ оплаты');
	        $table->integer('request_type', false, true)->nullable()->comment('Тип заявки');
	        $table->integer('pay_to_service_status', false, true)->nullable()->comment('Статус оплаты на сервис');
	        $table->integer('status_id', false, true)->nullable()->comment('Статус заявки');
	        $table->decimal('redeemed',19,8)->default(0)->comment('Объем выкупленной суммы, если выкуп по частям');
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
        Schema::dropIfExists('exchange_requests');
    }
}
