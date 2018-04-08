<?php

use Illuminate\Database\Seeder;

class WalletsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('wallets')->insert([
		    [
			    'id'                => 1,
			    'user_id'           => 1,
			    'payment_system_id' => 1,
			    'wallet_number'     => 'PUSD987156357',
			    'wallet_type'       => 'system',
			    'currency_id'       => 7
		    ],[
			    'id'                => 2,
			    'user_id'           => 1,
			    'payment_system_id' => 1,
			    'wallet_number'     => 'PRUB987156357',
			    'wallet_type'       => 'system',
			    'currency_id'       => 6
		    ],[
			    'id'                => 3,
			    'user_id'           => 1,
			    'payment_system_id' => 2,
			    'wallet_number'     => 'QIWI987156357',
			    'wallet_type'       => 'system',
			    'currency_id'       => 9
		    ],[
			    'id'                => 4,
			    'user_id'           => 1,
			    'payment_system_id' => 3,
			    'wallet_number'     => '987156357',
			    'wallet_type'       => 'system',
			    'currency_id'       => 1
		    ],[
			    'id'                => 5,
			    'user_id'           => 1,
			    'payment_system_id' => 3,
			    'wallet_number'     => '325156357',
			    'wallet_type'       => 'system',
			    'currency_id'       => 3
		    ],[
			    'id'                => 6,
			    'user_id'           => 1,
			    'payment_system_id' => 3,
			    'wallet_number'     => '958156357',
			    'wallet_type'       => 'system',
			    'currency_id'       => 2
		    ],[
			    'id'                => 7,
			    'user_id'           => 1,
			    'payment_system_id' => 5,
			    'wallet_number'     => '958156536',
			    'wallet_type'       => 'system',
			    'currency_id'       => 1
		    ],[
			    'id'                => 8,
			    'user_id'           => 1,
			    'payment_system_id' => 5,
			    'wallet_number'     => '958156536',
			    'wallet_type'       => 'system',
			    'currency_id'       => 3
		    ],[
			    'id'                => 9,
			    'user_id'           => 1,
			    'payment_system_id' => 5,
			    'wallet_number'     => '958156536',
			    'wallet_type'       => 'system',
			    'currency_id'       => 2
		    ],[
			    'id'                => 10,
			    'user_id'           => 1,
			    'payment_system_id' => 4,
			    'wallet_number'     => 'YA958156536',
			    'wallet_type'       => 'system',
			    'currency_id'       => 8
		    ],[
			    'id'                => 11,
			    'user_id'           => 1,
			    'payment_system_id' => 6,
			    'wallet_number'     => 'WMZ958156536',
			    'wallet_type'       => 'system',
			    'currency_id'       => 4
		    ],[
			    'id'                => 12,
			    'user_id'           => 1,
			    'payment_system_id' => 6,
			    'wallet_number'     => 'WMR958156536',
			    'wallet_type'       => 'system',
			    'currency_id'       => 5
		    ],[
			    'id'                => 13,
			    'user_id'           => 1,
			    'payment_system_id' => 7,
			    'wallet_number'     => 'PMUSD958156536',
			    'wallet_type'       => 'system',
			    'currency_id'       => 10
		    ],[
			    'id'                => 14,
			    'user_id'           => 1,
			    'payment_system_id' => 7,
			    'wallet_number'     => 'PMEUR958156536',
			    'wallet_type'       => 'system',
			    'currency_id'       => 11
		    ],[
			    'id'                => 15,
			    'user_id'           => 1,
			    'payment_system_id' => 8,
			    'wallet_number'     => 'OKUSD958156536',
			    'wallet_type'       => 'system',
			    'currency_id'       => 12
		    ],[
			    'id'                => 16,
			    'user_id'           => 1,
			    'payment_system_id' => 8,
			    'wallet_number'     => 'OKRUB958156536',
			    'wallet_type'       => 'system',
			    'currency_id'       => 13
		    ],[
			    'id'                => 17,
			    'user_id'           => 1,
			    'payment_system_id' => 9,
			    'wallet_number'     => 'W1USD958156536',
			    'wallet_type'       => 'system',
			    'currency_id'       => 14
		    ],[
			    'id'                => 18,
			    'user_id'           => 1,
			    'payment_system_id' => 9,
			    'wallet_number'     => 'W1RUB958156536',
			    'wallet_type'       => 'system',
			    'currency_id'       => 15
		    ],[
			    'id'                => 19,
			    'user_id'           => 1,
			    'payment_system_id' => 10,
			    'wallet_number'     => 'SKUSD958156536',
			    'wallet_type'       => 'system',
			    'currency_id'       => 16
		    ],[
			    'id'                => 20,
			    'user_id'           => 1,
			    'payment_system_id' => 10,
			    'wallet_number'     => 'SKEUR958156536',
			    'wallet_type'       => 'system',
			    'currency_id'       => 17
		    ],[
			    'id'                => 21,
			    'user_id'           => 1,
			    'payment_system_id' => 11,
			    'wallet_number'     => 'ACUSD958156536',
			    'wallet_type'       => 'system',
			    'currency_id'       => 18
		    ],[
			    'id'                => 22,
			    'user_id'           => 1,
			    'payment_system_id' => 12,
			    'wallet_number'     => 'PZUSD958156536',
			    'wallet_type'       => 'system',
			    'currency_id'       => 19
		    ],[
			    'id'                => 23,
			    'user_id'           => 1,
			    'payment_system_id' => 13,
			    'wallet_number'     => '489364582',
			    'wallet_type'       => 'system',
			    'currency_id'       => 1
		    ],[
			    'id'                => 24,
			    'user_id'           => 1,
			    'payment_system_id' => 13,
			    'wallet_number'     => '489364756',
			    'wallet_type'       => 'system',
			    'currency_id'       => 2
		    ],[
			    'id'                => 25,
			    'user_id'           => 1,
			    'payment_system_id' => 13,
			    'wallet_number'     => '725364756',
			    'wallet_type'       => 'system',
			    'currency_id'       => 3
		    ],[
			    'id'                => 26,
			    'user_id'           => 1,
			    'payment_system_id' => 14,
			    'wallet_number'     => '725364756',
			    'wallet_type'       => 'system',
			    'currency_id'       => 1
		    ],[
			    'id'                => 27,
			    'user_id'           => 1,
			    'payment_system_id' => 14,
			    'wallet_number'     => '489364582',
			    'wallet_type'       => 'system',
			    'currency_id'       => 2
		    ],[
			    'id'                => 28,
			    'user_id'           => 1,
			    'payment_system_id' => 14,
			    'wallet_number'     => '428953148',
			    'wallet_type'       => 'system',
			    'currency_id'       => 3
		    ],[
			    'id'                => 29,
			    'user_id'           => 1,
			    'payment_system_id' => 15,
			    'wallet_number'     => '725364756',
			    'wallet_type'       => 'system',
			    'currency_id'       => 1
		    ],[
			    'id'                => 30,
			    'user_id'           => 1,
			    'payment_system_id' => 15,
			    'wallet_number'     => '489364582',
			    'wallet_type'       => 'system',
			    'currency_id'       => 2
		    ],[
			    'id'                => 31,
			    'user_id'           => 1,
			    'payment_system_id' => 15,
			    'wallet_number'     => '428953148',
			    'wallet_type'       => 'system',
			    'currency_id'       => 3
		    ],[
			    'id'                => 32,
			    'user_id'           => 1,
			    'payment_system_id' => 16,
			    'wallet_number'     => '725364756',
			    'wallet_type'       => 'system',
			    'currency_id'       => 1
		    ],[
			    'id'                => 33,
			    'user_id'           => 1,
			    'payment_system_id' => 16,
			    'wallet_number'     => '489364582',
			    'wallet_type'       => 'system',
			    'currency_id'       => 2
		    ],[
			    'id'                => 34,
			    'user_id'           => 1,
			    'payment_system_id' => 16,
			    'wallet_number'     => '428953148',
			    'wallet_type'       => 'system',
			    'currency_id'       => 3
		    ],[
			    'id'                => 35,
			    'user_id'           => 1,
			    'payment_system_id' => 17,
			    'wallet_number'     => '725364756',
			    'wallet_type'       => 'system',
			    'currency_id'       => 1
		    ],[
			    'id'                => 36,
			    'user_id'           => 1,
			    'payment_system_id' => 17,
			    'wallet_number'     => '489364582',
			    'wallet_type'       => 'system',
			    'currency_id'       => 2
		    ],[
			    'id'                => 37,
			    'user_id'           => 1,
			    'payment_system_id' => 17,
			    'wallet_number'     => '428953148',
			    'wallet_type'       => 'system',
			    'currency_id'       => 3
		    ],

		    //crypt

		    [
			    'id'                => 38,
			    'user_id'           => 1,
			    'payment_system_id' => 18,
			    'wallet_number'     => 'BTC1111111',
			    'wallet_type'       => 'system',
			    'currency_id'       => 20
		    ],
		    [
			    'id'                => 39,
			    'user_id'           => 1,
			    'payment_system_id' => 19,
			    'wallet_number'     => 'BCH1111111',
			    'wallet_type'       => 'system',
			    'currency_id'       => 21
		    ],
		    [
			    'id'                => 40,
			    'user_id'           => 1,
			    'payment_system_id' => 20,
			    'wallet_number'     => 'ETH111111',
			    'wallet_type'       => 'system',
			    'currency_id'       => 22
		    ],
		    [
			    'id'                => 41,
			    'user_id'           => 1,
			    'payment_system_id' => 21,
			    'wallet_number'     => 'XRP111111',
			    'wallet_type'       => 'system',
			    'currency_id'       => 23
		    ],
		    [
			    'id'                => 42,
			    'user_id'           => 1,
			    'payment_system_id' => 22,
			    'wallet_number'     => 'LTC111111',
			    'wallet_type'       => 'system',
			    'currency_id'       => 24
		    ],
		    [
			    'id'                => 43,
			    'user_id'           => 1,
			    'payment_system_id' => 23,
			    'wallet_number'     => 'IOT111111',
			    'wallet_type'       => 'system',
			    'currency_id'       => 25
		    ],
		    [
			    'id'                => 44,
			    'user_id'           => 1,
			    'payment_system_id' => 24,
			    'wallet_number'     => 'DASH11111',
			    'wallet_type'       => 'system',
			    'currency_id'       => 26
		    ],
		    [
			    'id'                => 45,
			    'user_id'           => 1,
			    'payment_system_id' => 25,
			    'wallet_number'     => 'NEM111111',
			    'wallet_type'       => 'system',
			    'currency_id'       => 27
		    ],
		    [
			    'id'                => 46,
			    'user_id'           => 1,
			    'payment_system_id' => 26,
			    'wallet_number'     => 'XMR111111',
			    'wallet_type'       => 'system',
			    'currency_id'       => 28
		    ],
		    [
			    'id'                => 47,
			    'user_id'           => 1,
			    'payment_system_id' => 27,
			    'wallet_number'     => 'NEO111111',
			    'wallet_type'       => 'system',
			    'currency_id'       => 29
		    ],
		    [
			    'id'                => 48,
			    'user_id'           => 1,
			    'payment_system_id' => 28,
			    'wallet_number'     => 'ETC111111',
			    'wallet_type'       => 'system',
			    'currency_id'       => 30
		    ],
		    [
			    'id'                => 49,
			    'user_id'           => 1,
			    'payment_system_id' => 29,
			    'wallet_number'     => 'ZEC111111',
			    'wallet_type'       => 'system',
			    'currency_id'       => 31
		    ],
		    [
			    'id'                => 50,
			    'user_id'           => 1,
			    'payment_system_id' => 30,
			    'wallet_number'     => 'WAVES111111',
			    'wallet_type'       => 'system',
			    'currency_id'       => 32
		    ],
	    ]);
    }
}
