<?php

use Illuminate\Database\Seeder;

class EquivalentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('equivalents')->insert([
        	[
        		'name' => 'Российский рубль',
		        'code' => 'RUR',
		        'sign' => '₽'
	        ],
	        [
		        'name' => 'Американский доллар',
		        'code' => 'USD',
		        'sign' => '$'
	        ],
	        [
		        'name' => 'Евро',
		        'code' => 'EUR',
		        'sign' => '€'
	        ],
	        [
		        'name' => 'Криптовалюта',
		        'code' => 'CRPT',
		        'sign' => 'coin'
	        ]
        ]);
    }
}
