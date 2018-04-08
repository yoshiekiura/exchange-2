<?php

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('currencies')->insert([
		    //Фиатная валюта
		    [
			    'name'  => 'Российский рубль',
			    'code'  => 'RUB',
			    'sign'  => '₽',
			    'equivalent_id' => 1,

		    ],
		    [
			    'name'  => 'Евро',
			    'code'  => 'EUR',
			    'sign'  => '€',
			    'equivalent_id' => 3,

		    ],
		    [
			    'name'  => 'Американский доллар',
			    'code'  => 'USD',
			    'sign'  => '$',
			    'equivalent_id' => 2,

		    ],
		    [
			    'name'  => 'WMZ',
			    'code'  => 'WMZ',
			    'sign'  => '$',
			    'equivalent_id' => 2,

		    ],
		    [
			    'name'  => 'WMR',
			    'code'  => 'WMR',
			    'sign'  => '₽',
			    'equivalent_id' => 1,

		    ],
		    [
			    'name'  => 'PayPal - рубли',
			    'code'  => 'PPRUB',
			    'sign'  => '₽',
			    'equivalent_id' => 1,

		    ],
		    [
			    'name'  => 'PayPal - доллары США',
			    'code'  => 'PPUSD',
			    'sign'  => '$',
			    'equivalent_id' => 2,

		    ],
		    [
			    'name'  => 'Яндекс.Деньги',
			    'code'  => 'YRUB',
			    'sign'  => '₽',
			    'equivalent_id' => 1,

		    ],
		    [
			    'name'  => 'QIWI',
			    'code'  => 'QIWIRUB',
			    'sign'  => '₽',
			    'equivalent_id' => 1,

		    ],
		    [
			    'name'  => 'Perfect Money USD',
			    'code'  => 'PMUSD',
			    'sign'  => '$',
			    'equivalent_id' => 2,

		    ],
		    [
			    'name'  => 'Perfect Money EUR',
			    'code'  => 'PMEUR',
			    'sign'  => '€',
			    'equivalent_id' => 3,

		    ],
		    [
			    'name'  => 'OKPay USD',
			    'code'  => 'OKUSD',
			    'sign'  => '$',
			    'equivalent_id' => 2,

		    ],
		    [
			    'name'  => 'OKPay RUB',
			    'code'  => 'OKRUB',
			    'sign'  => '₽',
			    'equivalent_id' => 1,

		    ],
		    [
			    'name'  => 'W1 USD',
			    'code'  => 'W1USD',
			    'sign'  => '$',
			    'equivalent_id' => 2,

		    ],
		    [
			    'name'  => 'W1 RUB',
			    'code'  => 'W1RUB',
			    'sign'  => '₽',
			    'equivalent_id' => 1,

		    ],
		    [
			    'name'  => 'Skrill USD',
			    'code'  => 'SKUSD',
			    'sign'  => '$',
			    'equivalent_id' => 2,

		    ],
		    [
			    'name'  => 'Skrill EUR',
			    'code'  => 'SKEUR',
			    'sign'  => '€',
			    'equivalent_id' => 3,

		    ],
		    [
			    'name'  => 'Advanced Cash USD',
			    'code'  => 'ACUSD',
			    'sign'  => '$',
			    'equivalent_id' => 2,

		    ],
		    [
			    'name'  => 'Payza USD',
			    'code'  => 'PZUSD',
			    'sign'  => '$',
			    'equivalent_id' => 2,
		    ],
				//Криптовалюта
		    [
			    'name'  => 'Bitcoin',
			    'code'  => 'BTC',
			    'sign'  => 'BTC',
			    'equivalent_id' => 4,
		    ],
		    [
			    'name'  => 'Bitcoin cash',
			    'code'  => 'BCH',
			    'sign'  => 'BCH',
			    'equivalent_id' => 4,
		    ],
		    [
			    'name'  => 'Ethereum',
			    'code'  => 'ETH',
			    'sign'  => 'ETH',
			    'equivalent_id' => 4,
		    ],
		    [
			    'name'  => 'Ripple',
			    'code'  => 'XRP',
			    'sign'  => 'XRP',
			    'equivalent_id' => 4,
		    ],
		    [
			    'name'  => 'Litecoin',
			    'code'  => 'LTC',
			    'sign'  => 'LTC',
			    'equivalent_id' => 4,
		    ],
		    [
			    'name'  => 'IOTA',
			    'code'  => 'IOT',
			    'sign'  => 'IOT',
			    'equivalent_id' => 4,
		    ],
		    [
			    'name'  => 'Dash',
			    'code'  => 'DASH',
			    'sign'  => 'DASH',
			    'equivalent_id' => 4,
		    ],
		    [
			    'name'  => 'Nem',
			    'code'  => 'XEM',
			    'sign'  => 'XEM',
			    'equivalent_id' => 4,
		    ],
		    [
			    'name'  => 'Monero',
			    'code'  => 'XMR',
			    'sign'  => 'XMR',
			    'equivalent_id' => 4,
		    ],
		    [
			    'name'  => 'Neo',
			    'code'  => 'NEO',
			    'sign'  => 'NEO',
			    'equivalent_id' => 4,
		    ],
		    [
			    'name'  => 'Ethereum classic',
			    'code'  => 'ETC',
			    'sign'  => 'ETC',
			    'equivalent_id' => 4,
		    ],
		    [
			    'name'  => 'Zcash',
			    'code'  => 'ZEC',
			    'sign'  => 'ZEC',
			    'equivalent_id' => 4,
		    ],
		    [
			    'name'  => 'Waves',
			    'code'  => 'WAVES',
			    'sign'  => 'WAVES',
			    'equivalent_id' => 4,
		    ],
	    ]);
    }
}

/**
 * bitcoin - BTC
 * bitcoin cash - BCH
 * ethereum - ETH
 * ripple - XRP
 * litecoin - LTC
 * IOTA - ? IOT - IOT not supported
 * dash - DASH
 * cardano - ? - not supported
 * nem - XEM
 * bitcoin gold - BTG not supported
 * monero - XMR
 * neo - NEO
 * eth classic - ETC
 * zcash - ZEC
 * waves - WAVES
 */
