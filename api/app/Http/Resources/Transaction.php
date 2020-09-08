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
        if (request()->id == $this->from) {
            $transactionType = '- ';
            $formattedAmount = $transactionType.($this->fromInfo->currency ?? '').' '.$this->from_amount;
        } else {
            $transactionType = '+ ';
            $formattedAmount = $transactionType.($this->toInfo->currency ?? '').' '.$this->to_amount;
        }

        return [
            'id' => $this->id,
            'from' => (new AccountResource($this->whenLoaded('fromInfo')))->name ?? '',
            'from_amount' => $this->from_amount,
            'to' => (new AccountResource($this->whenLoaded('toInfo')))->name ?? '',
            'to_amount' => $this->to_amount,
            'details' => $this->details,
            'amount' => $formattedAmount,
            'date' => date('m/d/Y', strtotime($this->created_at))
        ];
    }
}
