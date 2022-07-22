<?php

namespace App\Repositories\Eloquent;

use App\Repositories\TransactionRepositoryInterface;
use App\Entities\Transaction;
use App\Models\Transaction as TransactionModel;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function __construct(
        private TransactionModel $transactionModel
    ) {
    }

    /**
     * @param Transaction $transaction
     * @return Transaction
     */
    public function create(Transaction $transaction): Transaction
    {
        $transactionModel = $this->transactionModel::create($transaction->toArray());

        return Transaction::fromArray($transactionModel->toArray());
    }

    /**
     * @param string $transactionId
     * @return Transaction
     */
    public function findById(string $transactionId): Transaction
    {
        $transactionModel = $this->transactionModel::find($transactionId);

        return Transaction::fromArray($transactionModel->toArray());
    }

    /**
     * @param Transaction $transaction
     * @param string $status
     * @return void
     */
    public function updateStatus(Transaction $transaction, string $status): void
    {
        $transactionModel = $this->transactionModel::find($transaction->id);

        $transactionModel->update(["status" => $status]);
    }
}
