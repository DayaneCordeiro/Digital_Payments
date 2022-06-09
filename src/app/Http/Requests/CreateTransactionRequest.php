<?php

namespace App\Http\Requests;

use App\Rules\Transaction\PayerMustDifferentOfPayee;
use App\Rules\Transaction\UserHasEnoughBalance;
use App\Rules\Transaction\UserMustBeActive;
use App\Rules\Transaction\UserMustBeCommonType;
use App\Rules\Transaction\UserWalletMustExists;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CreateTransactionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'payer_id' => [
                'exists:users,id',
                'required',
                new UserMustBeCommonType((int) request()->get('payer_id')),
                new UserMustBeActive((int) request()->get('payer_id')),
                new PayerMustDifferentOfPayee((int) request()->get('payer_id'), (int) request()->get('payee_id')),
                new UserWalletMustExists((int) request()->get('payer_id')),
            ],
            'payee_id' => [
                'exists:users,id',
                'required',
                new UserMustBeActive((int) request()->get('payee_id')),
                new UserWalletMustExists((int) request()->get('payee_id')),
            ],
            'value' => [
                'required',
                new UserHasEnoughBalance((int) request()->get('payer_id'), (float) request()->get('value'))
            ]
        ];
    }

    public function messages()
    {
        return [
            'payer_id.exists' => 'User not found.',
            'payee_id.exists' => 'User not found.',
            'payer_id.required' => 'Payer id is required.',
            'payee_id.required' => 'Payee id is required.',
            'value.required' => 'Value is required.',
        ];
    }

    protected function failedValidation(Validator $validator): ValidationException
    {
        throw (new ValidationException($validator, response()->json([
            'errors' => $validator->getMessageBag()->getMessages()
        ], Response::HTTP_BAD_REQUEST)));
    }
}
