<?php

namespace App\Repositories;

use App\Entities\Transaction;

interface TransactionRepositoryInterface
{
    public function create(Transaction $transaction): Transaction;
}
