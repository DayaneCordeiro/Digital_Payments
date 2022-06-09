<?php

namespace App\Rules\Transaction;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserWalletMustExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private int $userId)
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
        $wallet = DB::table('wallets')->where('user_id', $this->userId)->first();
        return !is_null($wallet);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'User wallet not found.';
    }
}
