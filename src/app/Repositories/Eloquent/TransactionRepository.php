<?php

namespace App\Repositories\Eloquent;

use App\Repositories\TransactionRepositoryInterface;
use App\Entities\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{

    public function create(Transaction $transaction): Transaction
    {
        // TODO: Implement create() method.
    }
}
