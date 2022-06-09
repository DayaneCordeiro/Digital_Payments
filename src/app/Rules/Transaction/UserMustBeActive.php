<?php

namespace App\Rules\Transaction;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UserMustBeActive implements Rule
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
        $user = User::find($this->userId);

        return isset($user) && $user->status == 'active';
    }

    /**
     * @return string
     */
    public function message()
    {
        return 'Inactive user cannot complete the transaction.';
    }
}
