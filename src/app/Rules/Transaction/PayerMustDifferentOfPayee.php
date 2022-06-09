<?php

namespace App\Rules\Transaction;

use Illuminate\Contracts\Validation\Rule;

class PayerMustDifferentOfPayee implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private int $payerId, private int $payeeId)
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
        return $this->payerId != $this->payeeId;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'It is not possible to make a transaction for yourself.';
    }
}
