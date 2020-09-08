<?php

namespace App\Http\Controllers\API\AccountController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionCollection;
use App\Exceptions\InsufficientBalanceException;
use App\Http\Services\AccountServices\AccountInterface;
use App\Http\Services\CurrencyServices\CurrencyInterface;
use App\Http\Services\TransactionServices\TransactionInterface;

class AccountTransactionController extends Controller
{
    public $accountService;
    public $transactionService;
    public $currencyService;

    public function __construct(AccountInterface $accountService, 
        TransactionInterface $transactionService, CurrencyInterface $currencyService)
    {
        $this->accountService = $accountService;
        $this->transactionService = $transactionService;
        $this->currencyService = $currencyService;

        $currentAction = explode('@', \Route::currentRouteAction());
        if( $currentAction[1] == 'store' ) {
            // fill required field before validating TransactionRequest
            request()->merge([
                'from' => request()->id
            ]);
        }

    }

    /**
     * List all transactions of the account
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new TransactionCollection($this->accountService->getTransactions(request()->id));
    }

    /**
     * Start processing banking transactions
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request, $id)
    {
        return DB::transaction(function($query) use($request) {

            $from = $this->accountService->getInfo($request->from);

            if (!$this->accountService->isSufficientBalance($from, $request->amount)) {
                throw new InsufficientBalanceException();
            }

            $this->accountService->withdraw($from, $request->amount);

            $to = $this->accountService->getInfo($request->to);

            // convert requested amount to selected currency
            $convertedRequestAmount = $this->currencyService->convertAmount($from->currency, $to->currency, $request->amount);

            $this->accountService->deposit($to, $convertedRequestAmount);

            $request['from_amount'] = $request->amount;
            $request['to_amount'] = $convertedRequestAmount;

            return $this->transactionService->save($request);

        });

    }
    
}
