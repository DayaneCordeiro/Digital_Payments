<?php

namespace App\Services;

use App\Entities\Transaction;
use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Repositories\AuthorizationRepository;
use App\Repositories\TransactionRepositoryInterface;

class TransactionService
{
    public function __construct(
        protected TransactionRepositoryInterface $transactionRepository,
        protected AuthorizationRepository $authorizationRepository
    )
    {
    }

    public function create(CreateTransactionRequest $transactionRequest)
    {
        $authorizationUrl = config('services.transaction.authorization');

        $authorization = $this->authorizationRepository->autorize($authorizationUrl);

        $this->transactionRepository->create(
            new Transaction(
                payerId: $transactionRequest->get('payer_id'),
                payeeId: $transactionRequest->get('payee_id'),
                value: $transactionRequest->get('value'),
                status: null,
                createdAt: null,
                updatedAt: null,
                id: null
            )
        );

        dd($authorization);

        return null;
    }
}
