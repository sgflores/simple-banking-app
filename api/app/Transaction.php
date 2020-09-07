<?php

namespace App;

use App\Traits\EloquentHelpers;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use EloquentHelpers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from', 'to', 'details', 'currency', 'amount',
    ];

    /**
     * Get the info of the account from
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromInfo()
    {
        return $this->belongsTo(\App\Account::class, 'from', 'id');
    }

    /**
     * Get the info of the account to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toInfo()
    {
        return $this->belongsTo(\App\Account::class, 'to', 'id');
    }
}
