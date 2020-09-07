<?php

use App\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usd = Config::get('constants.currency.usd');

        Transaction::create([
            'from' => 1,
            'to' => 2,
            'details' => 'sample transaction',
            'currency' => $usd,
            'amount' => 14,
        ]);

        Transaction::create([
            'from' => 1,
            'to' => 2,
            'details' => 'sample transaction 2',
            'currency' => $usd,
            'amount' => 24,
        ]);

        Transaction::create([
            'from' => 2,
            'to' => 1,
            'details' => 'sample transaction 3',
            'currency' => $usd,
            'amount' => 15,
        ]);

    }
}
