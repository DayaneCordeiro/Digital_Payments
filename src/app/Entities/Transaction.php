<?php

declare(strict_types=1);

namespace App\Entities;

use Carbon\Carbon;

class Transaction
{
    public function __construct(
        public int $payerId,
        public int $payeeId,
        public float $value,
        public ?string $status = null,
        public ?Carbon $updatedAt = null,
        public ?Carbon $createdAt = null,
        public ?int $id = null
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

    public static function fromArray(array $transactionModel): self
    {
        return new Transaction(
            payerId: $transactionModel['payer_id'],
            payeeId:  $transactionModel['payee_id'],
            value: $transactionModel['value'],
            status: $transactionModel['status'],
            updatedAt: new Carbon ($transactionModel['updated_at']),
            createdAt: new Carbon ($transactionModel['created_at']),
            id: $transactionModel['id']
        );
    }

    /**
     * @param string $status
     * @return void
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
