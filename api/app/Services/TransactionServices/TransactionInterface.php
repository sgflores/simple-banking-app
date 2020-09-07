<?php

namespace App\Http\Services\TransactionServices;

use Illuminate\Http\Request;

interface TransactionInterface
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Model
     */
    public function save(Request $request);


}