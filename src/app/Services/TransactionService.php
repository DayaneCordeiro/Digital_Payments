<?php

namespace App\Services;

use App\Entities\Transaction;
use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Repositories\AuthorizationRepository;
use App\Repositories\SendEmailRepository;
use App\Repositories\TransactionRepositoryInterface;
use App\Models\Transaction as TransactionModel;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

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
     * @return TransactionModel
     */
    public function create(CreateTransactionRequest $transactionRequest): TransactionModel
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

    /**
     * @param string $transactionId
     * @return void
     */
    public function cancel(string $transactionId): void
    {
        $transaction = $this->transactionRepository->findById($transactionId);

        $this->walletService->subtractValueFromWallet($transaction->payee_id, $transaction->value);

        $this->walletService->addValueFromWallet($transaction->payer_id, $transaction->value);

        $this->transactionRepository->updateStatus($transaction, 'canceled');
    }

    /**
     * @param string $transactionId
     * @return TransactionModel
     */
    public function findById(string $transactionId): array
    {
        return $this->transactionRepository->findById($transactionId);
    }

    public function cancelByTimeTolerance(string $transactionId)
    {
        $transaction = $this->transactionRepository->findById($transactionId);

        $transactionTime = new Carbon($transaction->created_at);

        $now = Carbon::now();

        $timeDifference = $now->diffInMinutes($transactionTime);

        if ($timeDifference > 5) {
            return [
                'message' => [
                    'message' => 'Cancellation tolerance time exceeded, please contact the bank.'
                ],
                'status_code' => Response::HTTP_BAD_REQUEST
            ];
        }

        $this->walletService->subtractValueFromWallet($transaction->payee_id, $transaction->value);

        $this->walletService->addValueFromWallet($transaction->payer_id, $transaction->value);

        $this->transactionRepository->updateStatus($transaction, 'canceled');

        return [
            'message' => null,
            'status_code' => Response::HTTP_NO_CONTENT
        ];
    }
}
