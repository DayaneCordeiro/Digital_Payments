<?php

namespace App\Rules\Transaction;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserMustBeCommonType implements Rule
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
        $userType = DB::table('users')->where('id', $this->userId)->pluck('type');

        return isset($userType[0]) && $userType[0] == 'common';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Payer must be common type.';
    }
}
