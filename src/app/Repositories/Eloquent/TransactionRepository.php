<?php

namespace App\Repositories\Eloquent;

use App\Repositories\TransactionRepositoryInterface;
use App\Entities\Transaction;
use App\Models\Transaction as TransactionModel;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function __construct(
        protected Transaction $transaction
    ) {
    }

    /**
     * @param Transaction $transaction
     * @return Transaction
     */
    public function create(Transaction $transaction): Transaction
    {
        $transactionModel = TransactionModel::create($transaction->toArray());

        return $this->transaction->fromModel($transactionModel);
    }

    /**
     * @param string $transactionId
     * @return Transaction
     */
    public function findById(string $transactionId): Transaction
    {
        $transactionModel = TransactionModel::find($transactionId);

        return $this->transaction->fromModel($transactionModel);
    }

    /**
     * @param Transaction $transaction
     * @param string $status
     * @return void
     */
    public function updateStatus(Transaction $transaction, string $status): void
    {
        $transactionModel = TransactionModel::find($transaction->id);

        $transactionModel->update(["status" => $status]);
    }
}
