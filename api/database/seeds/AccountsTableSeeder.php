<?php

use App\Account;
use Illuminate\Database\Seeder;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usd = Config::get('constants.currency.usd');

        Account::create([
            'name' => 'John',
            'currency' => $usd,
            'balance' => 15000,
        ]);

        Account::create([
            'name' => 'Peter',
            'currency' => $usd,
            'balance' => 100000,
        ]);

    }

}
