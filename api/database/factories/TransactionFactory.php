<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'from' => $faker->randomNumber(), 
        'to' => $faker->randomNumber(),
        'details' => $faker->text(),
        'currency', $faker->currencyCode,
        'amount', $faker->randomFloat()
    ];
});
