<?php

namespace App\Rules\Transaction;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserMustBeActive implements Rule
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
        $user = DB::table('users')->where('id', $this->userId)->pluck('status');
        return isset($user[0]) && $user[0] == 'active';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Inactive user cannot complete the transaction.';
    }
}
