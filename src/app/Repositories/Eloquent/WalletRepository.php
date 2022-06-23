<?php

namespace App\Repositories\Eloquent;

use App\Models\Wallet as WalletModel;
use App\Repositories\WalletRepositoryInterface;

class WalletRepository implements WalletRepositoryInterface
{
    public function findWalletByUserId(string $userId): WalletModel
    {
        return WalletModel::where("user_id", $userId)
            ->first();
    }

    public function updateWalletBalance(string $balance, WalletModel $wallet): void
    {
        $wallet->update(["balance" => $balance]);
    }
}
