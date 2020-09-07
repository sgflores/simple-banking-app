<?php

namespace App\Http\Controllers\API\AccountController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Account as AccountResource;
use App\Http\Services\AccountServices\AccountInterface;

class AccountInfoController extends Controller
{
    public $accountService;

    public function __construct(AccountInterface $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new AccountResource($this->accountService->getInfo($id));
    }

}
