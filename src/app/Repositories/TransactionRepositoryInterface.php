<?php

namespace App\Repositories;

use App\Entities\Transaction;
use App\Models\Transaction as TransactionModel;

interface TransactionRepositoryInterface
{
    public function create(Transaction $transaction): Transaction;

    public function findById(string $transactionId): TransactionModel;

    public function updateStatus(TransactionModel $transaction, string $status): void;
}
