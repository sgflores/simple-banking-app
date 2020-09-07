<?php

namespace App\Http\Services\TransactionServices;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Services\TransactionServices\TransactionInterface;

class TransactionService implements TransactionInterface 
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Model
     */
    public function save(Request $request)
    {
        return Transaction::create($request->all());
    }


}