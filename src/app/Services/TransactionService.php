<?php

namespace App\Services;

use App\Entities\Transaction;
use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Repositories\AuthorizationRepository;
use App\Repositories\SendEmailRepository;
use App\Repositories\TransactionRepositoryInterface;

class TransactionService
{
    public function __construct(
        protected TransactionRepositoryInterface $transactionRepository,
        protected AuthorizationRepository $authorizationRepository,
        protected SendEmailRepository $emailRepository,
        protected WalletService $walletService
    ) {
    }

    /**
     * @param CreateTransactionRequest $transactionRequest
     * @return \App\Models\Transaction
     */
    public function create(CreateTransactionRequest $transactionRequest)
    {
        $authorizationUrl = config('services.transaction.authorization');

        $authorization = $this->authorizationRepository->autorize($authorizationUrl);

        $transaction = $this->transactionRepository->create(
            new Transaction(
                payerId: $transactionRequest->get('payer_id'),
                payeeId: $transactionRequest->get('payee_id'),
                value: $transactionRequest->get('value'),
                status: ($authorization) ? "approved" : "not-approved"
            )
        );

        // implementar uma fila de envio?
        $this->emailRepository->sendEmail(config('services.email.confirmation'));

        $this->walletService->subtractValueFromWallet($transaction->payer_id, $transaction->value);

        $this->walletService->addValueFromWallet($transaction->payee_id, $transaction->value);

        return $transaction;
    }

    public function cancel(string $transactionId)
    {
        $transaction = $this->transactionRepository->findById($transactionId);

        $this->walletService->subtractValueFromWallet($transaction->payee_id, $transaction->value);

        $this->walletService->addValueFromWallet($transaction->payer_id, $transaction->value);

        $this->transactionRepository->updateStatus($transaction, 'canceled');
    }
}
