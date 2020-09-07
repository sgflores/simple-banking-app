<?php

namespace App;

use App\Transaction;
use App\Traits\EloquentHelpers;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use EloquentHelpers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'currency', 'balance',
    ];

}
