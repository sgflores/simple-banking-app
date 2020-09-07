<?php

namespace App\Http\Services\CurrencyServices;

use App\Currency;
use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;

class CurrencyService implements CurrencyInterface 
{

    /**
     * Display all resource
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        // return only valid currencies supported by ash-jc-allen/laravel-exchange-rates
        return Currency::whereIn('code', (new ExchangeRate())->currencies())
            ->orderBy('code', 'asc')
            ->get();
    }

    /**
     * Covert amount to proper currency conversion
     *
     * @param [String] $fromCurrency
     * @param [String] $toCurrency
     * @param [decimal] $amount
     * @return $amount
     */
    public function convertAmount($fromCurrency, $toCurrency, $amount)
    {
        $exchangeRates = new ExchangeRate();
        $rate = $exchangeRates->exchangeRate($fromCurrency, $toCurrency);
        return floatval($amount) * floatval($rate);
    }


}