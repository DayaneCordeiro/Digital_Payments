<?php

namespace App\Rules\Transaction;

use App\Models\Wallet;
use Illuminate\Contracts\Validation\Rule;

class UserWalletMustExists implements Rule
{
    /**
     * @param int $userId
     */
    public function __construct(
        private int $userId
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

        return !is_null($wallet);
    }

    /**
     * @return string
     */
    public function message()
    {
        return 'User wallet not found.';
    }
}
