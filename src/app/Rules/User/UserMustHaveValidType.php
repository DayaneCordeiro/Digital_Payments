<?php

namespace App\Rules\User;

use Illuminate\Contracts\Validation\Rule;

class UserMustHaveValidType implements Rule
{
    /**
     * @param string $userType
     */
    public function __construct(
        private string $userType
    )
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
        $acceptableTypes = ["common", "shopkeeper"];

        return in_array($this->userType, $acceptableTypes);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid user type.';
    }
}
