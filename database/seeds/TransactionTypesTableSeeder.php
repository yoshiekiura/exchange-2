<?php

use Illuminate\Database\Seeder;

class TransactionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transaction_types')->insert([
        	[
        		'name' => 'выкуп сразу'
	        ],
	        [
        		'name' => 'выкуп частями'
	        ],
        ]);
    }
}
