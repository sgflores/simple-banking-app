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
            'from_amount' => 1,
            'to' => 2,
            'to_amount' => 1,
            'details' => 'sample transaction',
        ]);

        Transaction::create([
            'from' => 1,
            'from_amount' => 2,
            'to' => 2,
            'to_amount' => 2,
            'details' => 'sample transaction 2',
        ]);

        Transaction::create([
            'from' => 2,
            'from_amount' => 15,
            'to' => 1,
            'to_amount' => 15,
            'details' => 'sample transaction 3',
        ]);

    }
}
