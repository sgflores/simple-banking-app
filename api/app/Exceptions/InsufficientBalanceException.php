<?php

namespace App\Exceptions;

use Exception;

class InsufficientBalanceException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            'errors' => [
                'amount' => 'Insufficient Account Balance'
            ]
        ], 422);
    }
}
