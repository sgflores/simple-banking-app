<?php

namespace App\Http\Services\CurrencyServices;

interface CurrencyInterface 
{

    /**
     * Display all resource
     *
     * @return \Illuminate\Http\Response
     */
    public function all();


    /**
     * Covert amount to proper currency conversion
     *
     * @param [String] $fromCurrency
     * @param [String] $toCurrency
     * @param [decimal] $amount
     * @return $amount
     */
    public function convertAmount($fromCurrency, $toCurrency, $amount);

}