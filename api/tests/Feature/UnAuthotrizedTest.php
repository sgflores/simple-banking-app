<?php

namespace Tests\Feature;

use App\Account;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnAuthotrizedTest extends TestCase
{
    
    /** @test */
    public function unauthorized()
    {
        $account = factory(Account::class)->create();

        $this->getJson('/api/accounts/'.$account->id)
        ->assertStatus(401);
    }
}
