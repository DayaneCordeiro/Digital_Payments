<?php

namespace App\Repositories;

use App\Entities\Transaction;
use App\Models\Transaction as TransactionModel;

interface TransactionRepositoryInterface
{
    public function create(Transaction $transaction): TransactionModel;
}
