<?php

namespace App\Http\Requests;

use App\Account;
use Illuminate\Foundation\Http\FormRequest;
use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // get valid currencies supported by ash-jc-allen/laravel-exchange-rates
        $validCurrencies = (new ExchangeRate())->currencies();
        $validCurrencies = implode(',', $validCurrencies);

        $balance = Account::find(request()->from)->balance ?? 0;

        return [
            'from' => 'required|numeric|different:to|exists:accounts,id',
            'to' => 'required|numeric|different:from|exists:accounts,id',
            'details' => 'required',
            'currency' => "required|in:$validCurrencies",
            'amount' => "required|numeric|min:0|not_in:0|max:$balance"
        ];
    }

    public function messages()
    {
        return [
            'from.different' => 'Cannot transfer to own account',
            'to.different' => 'Cannot transfer to own account',
            'amount.max' => 'Insufficient account balance',
        ];
    }

}
