<?php

namespace App\Repositories;

use App\Entities\Transaction;

interface TransactionRepositoryInterface
{
    public function create(Transaction $transaction): Transaction;

    public function findById(string $transactionId): Transaction;

    public function updateStatus(Transaction $transaction, string $status): void;
}
