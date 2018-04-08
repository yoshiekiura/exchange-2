<?php

use Illuminate\Database\Seeder;

class PaymentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_types')->insert([
        	[
				'name' => 'оплата сразу'
	        ],
	        [
				'name' => 'оплата по факту'
	        ],
        ]);
    }
}
