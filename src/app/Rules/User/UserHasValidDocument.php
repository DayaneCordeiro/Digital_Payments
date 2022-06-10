<?php

namespace App\Rules\User;

use App\Helpers\CnpjValidatorHelper;
use App\Helpers\CpfValidatorHelper;
use Illuminate\Contracts\Validation\Rule;

class UserHasValidDocument implements Rule
{
    /**
     * @param string $userDocument
     * @param string $userType
     */
    public function __construct(
        private string $userDocument,
        private string $userType
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
        return ($this->userType == 'common') ?
            CpfValidatorHelper::validateCpf($this->userDocument) :
            CnpjValidatorHelper::validateCnpj($this->userDocument);
    }

    /**
     * @return string
     */
    public function message()
    {
        return 'User document invalid.';
    }
}
