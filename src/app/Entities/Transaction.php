<?php

declare(strict_types=1);

namespace App\Entities;

class Transaction
{
    public function __construct(
        public int $payerId,
        public int $payeeId,
        public float $value,
        public ?string $status,
        public ?string $createdAt,
        public ?string $updatedAt,
        public ?int $id
    ) {
    }
}
