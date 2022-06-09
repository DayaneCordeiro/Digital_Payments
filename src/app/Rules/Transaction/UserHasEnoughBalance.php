<?php

namespace App\Rules\Transaction;

use App\Models\Wallet;
use Illuminate\Contracts\Validation\Rule;

class UserHasEnoughBalance implements Rule
{
    /**
     * @param int $userId
     * @param float $requestedValue
     */
    public function __construct(
        private int $userId,
        private float $requestedValue
    )
    {
    }

    /**
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $wallet = Wallet::where('user_id', $this->userId)->first();

        return isset($wallet) && $wallet->balance > $this->requestedValue;
    }

    /**
     * @return string
     */
    public function message()
    {
        return 'Insufficient balance to complete transaction.';
    }
}
