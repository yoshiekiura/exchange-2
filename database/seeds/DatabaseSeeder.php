<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(EquivalentTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(PaymentSystemsTableSeeder::class);
        $this->call(WalletsTableSeeder::class);
        $this->call(CurrencyPaymentSystemTableSeeder::class);
        $this->call(TransactionTypesTableSeeder::class);
        $this->call(PaymentTypesTableSeeder::class);
        $this->call(RequestTypesTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
        $this->call(HeroesTableSeeder::class);
    }
}
