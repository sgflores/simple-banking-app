<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Account as AccountResource;
use App\Http\Resources\Currency as CurrencyResource;

class Transaction extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $transactionType = request()->id == $this->from ? '-' : '+';
        $currencyCode = (new CurrencyResource($this->whenLoaded('currencyInfo')))->symbol ?? '';
        return [
            'id' => $this->id,
            'from' => (new AccountResource($this->whenLoaded('fromInfo')))->name ?? '',
            'to' => (new AccountResource($this->whenLoaded('toInfo')))->name ?? '',
            'details' => $this->details,
            'amount' => $transactionType.$currencyCode.number_format($this->amount, 2),
        ];
    }
}
