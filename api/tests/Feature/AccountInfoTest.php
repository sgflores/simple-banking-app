<?php

namespace Tests\Feature;

use App\Account;
use Tests\TestCase;
use App\Transaction;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountInfoTest extends TestCase
{
    public $defaultCurrency;

    public function setUp() : void
    {
        parent::setUp();
        // $this->withoutExceptionHandling();
        $this->defaultCurrency = Config::get('constants.currency.usd');
    }
    
    /** @test */
    public function can_view_account_info()
    {
        Passport::actingAsClient(factory(Client::class)->create(), []);

        $account = factory(Account::class)->create();

        $this->getJson('/api/accounts/'.$account->id)
        ->assertSuccessful()
        ->assertJsonStructure([
            'id', 'name', 'currency', 'balance'
        ]);
    }

    /** @test */
    public function can_view_account_transactions()
    {
        Passport::actingAsClient(factory(Client::class)->create(), []);

        $accountFrom = factory(Account::class)->create();

        $accountTo = factory(Account::class)->create();

        $transactions = Transaction::create([
            'from' => $accountFrom->id, 
            'to' => $accountTo->id,
            'details' => 'test',
            'currency' => $this->defaultCurrency,
            'amount' => 1000
        ]);

        $this->getJson('/api/accounts/'.$accountFrom->id.'/transactions')
        ->assertSuccessful()
        ->assertJsonStructure([
            'data' => [ 
                '*' => [  'id', 'from', 'to', 'details', 'amount' ] 
            ]
        ]);
    }
}
