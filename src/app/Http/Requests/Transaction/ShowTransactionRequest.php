<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ShowTransactionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'transaction' => [
                'exists:transactions,id'
            ]
        ];
    }

    public function messages()
    {
        return [
            'transaction.exists' => 'Transaction not found.'
        ];
    }

    protected function failedValidation(Validator $validator): ValidationException
    {
        throw (new ValidationException($validator, response()->json([
            'errors' => $validator->getMessageBag()->getMessages()
        ], Response::HTTP_BAD_REQUEST)));
    }
}
