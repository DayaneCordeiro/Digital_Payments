<?php

namespace App\Http\Requests\User;

use App\Rules\Transaction\PayerMustDifferentOfPayee;
use App\Rules\Transaction\UserHasEnoughBalance;
use App\Rules\Transaction\UserMustBeActive;
use App\Rules\Transaction\UserWalletMustExists;
use App\Rules\User\UserDontHaveRegisteredCpf;
use App\Rules\User\UserHasValidDocument;
use App\Rules\User\UserMustHaveValidStatus;
use App\Rules\User\UserMustHaveValidType;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CreateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'type' => [
                'required',
                new UserMustHaveValidType(
                    request()->get('type')
                ),
            ],
            'status' => [
                'required',
                new UserMustHaveValidStatus(
                    request()->get('status')
                ),
            ],
            'document' => [
                'unique:users,document',
                'required',
                'numeric',
                new UserHasValidDocument(
                    request()->get('document'),
                    request()->get('type')
                )
            ],
            'email' => [
                'unique:users,email',
                'required',
                'email'
            ],
            'name'=> [
                'required'
            ],
            'password' => [
                'required'
            ]
        ];
    }

    public function messages()
    {
        return [
            'document.unique' => 'User document is already in use.',
            'email.unique' => 'User email is already in use.'
        ];
    }

    protected function failedValidation(Validator $validator): ValidationException
    {
        throw (new ValidationException($validator, response()->json([
            'errors' => $validator->getMessageBag()->getMessages()
        ], Response::HTTP_BAD_REQUEST)));
    }
}

