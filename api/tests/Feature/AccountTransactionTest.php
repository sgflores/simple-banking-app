<?php

namespace Tests\Feature;

use App\Account;
use Tests\TestCase;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Config;
use App\Http\Services\CurrencyServices\CurrencyService;

class AccountTransactonTest extends TestCase
{

    public $defaultCurrency;

    public function setUp() : void
    {
        parent::setUp();
        // $this->withoutExceptionHandling();
        $this->defaultCurrency = Config::get('constants.currency.usd');
    }

    /** @test */
    public function can_not_transfer_if_missing_required_fields()
    {
        
        Passport::actingAsClient(factory(Client::class)->create(), []);

        $accountFrom = factory(Account::class)->create([
            'currency' => $this->defaultCurrency,
            'balance' => 1
        ]);

        // transfer money
        $this->postJson('/api/accounts/'.$accountFrom->id.'/transactions')
        ->assertStatus(422);
        
    }

    /** @test */
    public function can_not_transfer_if_insufficient_balance()
    {
        
        Passport::actingAsClient(factory(Client::class)->create(), []);

        $accountFrom = factory(Account::class)->create([
            'currency' => $this->defaultCurrency,
            'balance' => 1
        ]);

        $accountTo = factory(Account::class)->create([
            'currency' => $this->defaultCurrency,
            'balance' => 10
        ]);

        $request = [
            'from' => $accountFrom->id, 
            'to' => $accountTo->id,
            'details' => 'test',
            'currency' => $this->defaultCurrency,
            'amount' => 10
        ];
        
        // transfer money
        $this->postJson('/api/accounts/'.$accountFrom->id.'/transactions', $request)
        ->assertStatus(403);
        
    }


    /** @test */
    public function can_successfully_transfer_money_to_another_account()
    {
            
        /**
         * check if an account can succesfully transfer money to another account 
         * and also validate if the credited and debited amount are properly computed
         *
         */
        Passport::actingAsClient(factory(Client::class)->create(), []);

        $accountFrom = factory(Account::class)->create([
            'currency' => $this->defaultCurrency,
            'balance' => 10
        ]);

        $accountTo = factory(Account::class)->create([
            'currency' => $this->defaultCurrency,
            'balance' => 20
        ]);

        $transaction = [
            'from' => $accountFrom->id, 
            'to' => $accountTo->id,
            'details' => 'test',
            'currency' => 'PHP',
            'amount' => 1
        ];

        // transfer money
        $transaction = $this->postJson('/api/accounts/'.$accountFrom->id.'/transactions', $transaction)
        ->assertSuccessful()
        ->assertJsonStructure(['id', 'from', 'from_amount', 'to', 'to_amount', 'details']);

        $transaction = $transaction->decodeResponseJson();
        
        // check running balance is correct after withdrawal
        $runningBalance = $this->getCurrentBalance($accountFrom->id);
        $newBalance = (floatval($accountFrom->balance) - floatval($transaction['from_amount']));
        $this->assertEquals($runningBalance, $newBalance);

        // check running balance is correct after deposit
        $runningBalance = $this->getCurrentBalance($accountTo->id);
        $newBalance = (floatval($accountTo->balance) + floatval($transaction['to_amount']));
        $this->assertEquals($runningBalance, $newBalance);

    }

    public function getCurrentBalance($id)
    {
        return floatval($this->getJson('/api/accounts/'.$id)->decodeResponseJson()['balance']);
    }

    public function convertAmount($fromCurrency, $toCurrency, $amount)
    {
        $currencyService = new CurrencyService;
        return $currencyService->convertAmount($fromCurrency, $toCurrency, $amount);
    }

}
