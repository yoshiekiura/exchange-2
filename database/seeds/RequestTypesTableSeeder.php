<?php

use Illuminate\Database\Seeder;

class RequestTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('request_types')->insert([
        	[
        		'name' => 'запрос на обмен'
	        ],
	        [
	        	'name' => 'ответ на запрос'
	        ]
        ]);
    }
}
