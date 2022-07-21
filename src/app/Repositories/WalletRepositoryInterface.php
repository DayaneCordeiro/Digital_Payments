<?php

namespace App\Repositories;

use App\Models\Wallet as WalletModel;

interface WalletRepositoryInterface
{
    public function findWalletByUserId(string $userId): WalletModel;

    public function updateWalletBalance(string $balance, WalletModel $wallet);
}
