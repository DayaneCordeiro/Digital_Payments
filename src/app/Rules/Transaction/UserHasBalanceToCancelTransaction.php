<?php

namespace App\Rules\Transaction;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Contracts\Validation\Rule;

class UserHasBalanceToCancelTransaction implements Rule
{
    /**
     * @param int $transactionId
     */
    public function __construct(
        private int $transactionId
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
        $transaction = Transaction::find($this->transactionId);

        $wallet = Wallet::where('user_id', $transaction->payee_id)->first();

        return isset($wallet) && $wallet->balance >= $transaction->value;
    }

    /**
     * @return string
     */
    public function message()
    {
        return 'Insufficient balance to complete the operation.';
    }
}
