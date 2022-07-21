<?php

namespace App\Services;

use App\Repositories\WalletRepositoryInterface;

class WalletService
{
    public function __construct(
        protected WalletRepositoryInterface $walletRepository
    ) {
    }

    public function subtractValueFromWallet(string $userId, string $value): void
    {
        $wallet = $this->walletRepository->findWalletByUserId($userId);

        $finalBalance = $wallet->balance - $value;

        $this->walletRepository->updateWalletBalance($finalBalance, $wallet);
    }

    public function addValueFromWallet(string $userId, string $value): void
    {
        $wallet = $this->walletRepository->findWalletByUserId($userId);

        $finalBalance = (float) $wallet->balance + (float) $value;

        $this->walletRepository->updateWalletBalance($finalBalance, $wallet);
    }
}
