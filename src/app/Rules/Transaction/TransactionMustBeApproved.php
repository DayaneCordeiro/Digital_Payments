<?php

namespace App\Rules\Transaction;

use App\Models\Transaction;
use Illuminate\Contracts\Validation\Rule;

class TransactionMustBeApproved implements Rule
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

        return isset($transaction) && $transaction->status == 'approved';
    }

    /**
     * @return string
     */
    public function message()
    {
        return 'Transaction is already canceled.';
    }
}
