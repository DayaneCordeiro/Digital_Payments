<?php

namespace App\Rules\Transaction;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UserMustBeCommonType implements Rule
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

        return isset($user) && $user->type == 'common';
    }

    /**
     * @return string
     */
    public function message()
    {
        return 'Payer must be common type.';
    }
}
