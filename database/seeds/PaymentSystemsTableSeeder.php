<?php

use Illuminate\Database\Seeder;

class PaymentSystemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('payment_systems')->insert([
		    [
			    'name'          => 'PayPal',
			    'e_type'        => 'e_commerce',
		    ],
		    [
			    'name'          => 'QIWI',
			    'e_type'        => 'e_commerce',

		    ],
		    [
			    'name'          => 'Альфа-Банк',
			    'e_type'        => 'bank',

		    ],
		    [
			    'name'          => 'Яндекс.Деньги',
			    'e_type'        => 'e_commerce',

		    ],
		    [
			    'name'          => 'Сбербанк',
			    'e_type'        => 'bank',

		    ],
		    [
			    'name'          => 'WebMoney',
			    'e_type'        => 'e_commerce',

		    ],
		    [
			    'name'          => 'Perfect Money',
			    'e_type'        => 'e_commerce',

		    ],
		    [
			    'name'          => 'OKPay',
			    'e_type'        => 'e_commerce',

		    ],
		    [
			    'name'          => 'W1',
			    'e_type'        => 'e_commerce',
		    ],
		    [
			    'name'          => 'Skrill',
			    'e_type'        => 'e_commerce',
		    ],
		    [
			    'name'          => 'Advanced Cash',
			    'e_type'        => 'e_commerce',
		    ],
		    [
			    'name'          => 'Payza',
			    'e_type'        => 'e_commerce',
		    ],
	        [
			    'name'          => 'ВТБ Банк',
			    'e_type'        => 'bank',
		    ],
		    [
			    'name'          => 'Тинькофф Банк',
			    'e_type'        => 'bank',
		    ],
		    [
			    'name'          => 'Банк Русский Стандарт',
			    'e_type'        => 'bank',
		    ],
		    [
			    'name'          => 'Банк Открытие',
			    'e_type'        => 'bank',
		    ],
		    [
			    'name'          => 'Авангард Банк',
			    'e_type'        => 'bank',
		    ],

		    //Crypt
		    [
			    'name'   => 'Bitcoin',
	            'e_type' => 'crypt',
		    ],
		    [
			    'name'  => 'Bitcoin cash',
			    'e_type' => 'crypt',
		    ],
		    [
			    'name'  => 'Ethereum',
			    'e_type' => 'crypt',
		    ],
		    [
			    'name'  => 'Ripple',
			    'e_type' => 'crypt',
		    ],
		    [
			    'name'  => 'Litecoin',
			    'e_type' => 'crypt',
		    ],
		    [
			    'name'  => 'IOTA',
			    'e_type' => 'crypt',
		    ],
		    [
			    'name'  => 'Dash',
			    'e_type' => 'crypt',
		    ],
		    [
			    'name'  => 'Nem',
			    'e_type' => 'crypt',
		    ],
		    [
			    'name'  => 'Monero',
			    'e_type' => 'crypt',
		    ],
		    [
			    'name'  => 'Neo',
			    'e_type' => 'crypt',
		    ],
		    [
			    'name'  => 'Ethereum classic',
			    'e_type' => 'crypt',
		    ],
		    [
			    'name'  => 'Zcash',
			    'e_type' => 'crypt',
		    ],
		    [
			    'name'  => 'Waves',
			    'e_type' => 'crypt',
		    ],
	    ]);
    }
}
