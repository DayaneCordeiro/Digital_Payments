<?php

namespace App\Rules\Transaction;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserHasEnoughBalance implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private int $userId, private float $requestedValue)
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $wallet = DB::table('wallets')->where('id', $this->userId)->pluck('balance');
        return isset($wallet[0]) && $wallet[0] > $this->requestedValue;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Insufficient balance to complete transaction.';
    }
}
