<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyCollection;
use App\Http\Services\CurrencyServices\CurrencyInterface;

class CurrencyController extends Controller
{
    public $currencyService;

    public function __construct(CurrencyInterface $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        return new CurrencyCollection($this->currencyService->all());
    }
}
