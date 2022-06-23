<?php

namespace App\Repositories\Eloquent;

use App\Repositories\TransactionRepositoryInterface;
use App\Entities\Transaction;
use App\Models\Transaction as TransactionModel;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function create(Transaction $transaction): TransactionModel
    {
        return TransactionModel::create($transaction->toArray());
    }
}
