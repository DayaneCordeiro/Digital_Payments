<?php

declare(strict_types=1);

namespace App\Entities;

class Transaction
{
    public function __construct(
        public int $payerId,
        public int $payeeId,
        public float $value,
        public string $status
    ) {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'payer_id' => $this->payerId,
            'payee_id' => $this->payeeId,
            'value' => $this->value,
            'status' => $this->status
        ];
    }
}
