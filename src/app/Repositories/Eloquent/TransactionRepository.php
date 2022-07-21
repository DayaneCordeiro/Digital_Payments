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

    public function create(Transaction $transaction): Transaction
    {
        $transactionModel = TransactionModel::create($transaction->toArray());

        return $this->transaction->fromModel($transactionModel);
    }

    public function findById(string $transactionId): TransactionModel
    {
        return TransactionModel::find($transactionId);
    }

    public function updateStatus(TransactionModel $transaction, string $status): void
    {
        $transaction->update([
            "status" => $status
        ]);
    }
}
