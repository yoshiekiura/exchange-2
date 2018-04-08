<?php

use Illuminate\Database\Seeder;

class HeroesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('heroes')->insert([
            [
                'title' => 'Система обмена денежных средств в любых направлениях',
                'span' => 'gexch',
                'content' => '<p><strong>gexch </strong>это сервис где любой зарегистрированый участник может выставить заявку на обмен имеющийся у<br />
него валюты на нужную ему или обменять уже существующую заявку в нужном ему направлении.</p>'
            ]
        ]);
    }
}
