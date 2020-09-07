<?php

namespace App\Http\Services\AccountServices;

use App\Account;
use App\Transaction;
use Illuminate\Http\Request;

interface AccountInterface 
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Model
     */
    public function getInfo($id);

    
    /**
     * Display all transactions of the account
     *
     * @param  int  $id
     * @return Model Collection
     */
    public function getTransactions($id);

    /**
     * Validates if the current balance is sufficient enough for transfer
     *
     * @param Account $account
     * @param $amount
     * @return boolean
     */
    public function isSufficientBalance(Account $account, $amount);

    /**
     * Withdraw amount from the account
     *
     * @param Account $account
     * @param $amount
     * @return Model
     */
    public function withdraw(Account $account, $amount);

    /**
     * Deposit amount to the account
     *
     * @param Account $account
     * @param $amount
     * @return Model
     */
    public function deposit(Account $account, $amount);

}