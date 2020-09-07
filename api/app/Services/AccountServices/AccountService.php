<?php

namespace App\Http\Services\AccountServices;

use App\Account;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Services\AccountServices\AccountInterface;

class AccountService implements AccountInterface 
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Model
     */
    public function getInfo($id) 
    {
        return Account::findOrFail($id)->load('currencyInfo');
    }

    /**
     * Display all transactions of the account
     *
     * @param  int  $id
     * @return Model Collection
     */
    public function getTransactions($id)
    {
        return Transaction::where(function($query) use($id) {
            return $query->where('from', $id)
                ->orWhere('to', $id);
        })
        ->with(['currencyInfo', 'fromInfo', 'toInfo'])
        ->latest()
        ->get();
    }

    /**
     * Validates if the current balance is sufficient enough for transfer
     *
     * @param Account $from
     * @param $amount
     * @return boolean
     */
    public function isSufficientBalance(Account $account, $amount)
    {
        return floatval($account->balance) >= floatval($amount);
    }

    /**
     * Withdraw amount from the account
     *
     * @param Account $account
     * @param $amount
     * @return Model
     */
    public function withdraw(Account $account, $amount)
    {
        return tap($account)->update([
            'balance' => floatval($account->balance) - floatval($amount) 
        ]);
    }

    /**
     * Deposit amount to the account
     *
     * @param Account $account
     * @param $amount
     * @return Model
     */
    public function deposit(Account $account, $amount)
    {
        return tap($account)->update([
            'balance' => floatval($account->balance) + floatval($amount) 
        ]);
    }
}