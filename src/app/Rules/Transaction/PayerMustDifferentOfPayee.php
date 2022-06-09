<?php

namespace App\Rules\Transaction;

use Illuminate\Contracts\Validation\Rule;

class PayerMustDifferentOfPayee implements Rule
{
    /**
     * @param int $payerId
     * @param int $payeeId
     */
    public function __construct(
        private int $payerId,
        private int $payeeId
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
        return $this->payerId != $this->payeeId;
    }

    /**
     * @return string
     */
    public function message()
    {
        return 'It is not possible to make a transaction for yourself.';
    }
}
