<?php

namespace App\Http\Requests\Transaction;

use App\Rules\Transaction\TransactionMustBeApproved;
use App\Rules\Transaction\UserHasBalanceToCancelTransaction;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CancelTransactionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'transaction_id' => [
                'exists:transactions,id',
                new UserHasBalanceToCancelTransaction(
                    (int) request()->get('transaction_id')
                ),
                new TransactionMustBeApproved(
                    (int) request()->get('transaction_id')
                )
            ]
        ];
    }

    public function messages()
    {
        return [
            'transaction_id.exists' => 'Transaction not found.'
        ];
    }

    protected function failedValidation(Validator $validator): ValidationException
    {
        throw (new ValidationException($validator, response()->json([
            'errors' => $validator->getMessageBag()->getMessages()
        ], Response::HTTP_BAD_REQUEST)));
    }
}
