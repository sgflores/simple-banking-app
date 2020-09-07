<?php

namespace App\Traits;

trait EloquentHelpers {

    /**
     * Get the parent info of the currency
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currencyInfo()
    {
        return $this->belongsTo(\App\Currency::class, 'currency', 'code');
    }

}
