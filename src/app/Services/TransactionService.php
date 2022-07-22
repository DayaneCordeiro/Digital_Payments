<?php

namespace App\Services;

use App\Entities\Transaction;
use App\Repositories\AuthorizationRepository;
use App\Repositories\SendEmailRepository;
use App\Repositories\TransactionRepositoryInterface;
use Carbon\Carbon;

class TransactionService
{
    public const NOT_APPROVED_STATUS = 'not-approved';
    public const CANCELED_STATUS = 'canceled';

    public function __construct(
        protected TransactionRepositoryInterface $transactionRepository,
        protected AuthorizationRepository $authorizationRepository,
        protected SendEmailRepository $emailRepository,
        protected WalletService $walletService
    ) {
    }

    /**
     * @param Transaction $transaction
     * @return Transaction
     */
    public function create(Transaction $transaction): Transaction
    {
        $authorization = $this->authorizationRepository->authorize();

        $transaction->setStatus($authorization);

        $transactionResponse = $this->transactionRepository->create($transaction);

        if ($authorization != self::NOT_APPROVED_STATUS) {
            $this->emailRepository->sendEmail();

            $this->walletService->subtractValueFromWallet(
                $transactionResponse->payerId,
                $transactionResponse->value
            );

            $this->walletService->addValueFromWallet(
                $transactionResponse->payeeId,
                $transactionResponse->value
            );
        }

        return $transactionResponse;
    }

    /**
     * @param string $transactionId
     * @return void
     */
    public function cancel(string $transactionId): void
    {
        $transaction = $this->transactionRepository->findById($transactionId);

        $this->walletService->subtractValueFromWallet($transaction->payeeId, $transaction->value);

        $this->walletService->addValueFromWallet($transaction->payerId, $transaction->value);

        $this->transactionRepository->updateStatus($transaction, self::CANCELED_STATUS);
    }

    /**
     * @param string $transactionId
     * @return Transaction
     */
    public function findById(string $transactionId): Transaction
    {
        return $this->transactionRepository->findById($transactionId);
    }

    /**
     * @param string $transactionId
     * @return bool
     */
    public function cancelByTimeTolerance(string $transactionId): bool
    {
        $transaction = $this->transactionRepository->findById($transactionId);

        $transactionTime = new Carbon($transaction->createdAt);

        $now = Carbon::now();

        $timeDifference = $now->diffInMinutes($transactionTime);

        if ($timeDifference > 5) {
            return false;
        }

        $this->cancel($transactionId);

        return true;
    }
}
