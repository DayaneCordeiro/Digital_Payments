<?php

namespace App\Rules\User;

use Illuminate\Contracts\Validation\Rule;

class UserMustHaveValidStatus implements Rule
{
    /**
     * @param string $userStatus
     */
    public function __construct(
        private string $userStatus
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
        $acceptableStatus = ["active", "inactive"];

        return in_array($this->userStatus, $acceptableStatus);
    }

    /**
     * @return string
     */
    public function message()
    {
        return 'Invalid user status.';
    }
}
