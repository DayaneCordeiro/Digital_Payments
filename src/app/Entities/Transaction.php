<?php

declare(strict_types=1);

namespace App\Entities;

use App\Models\Transaction as TransactionModel;
use Carbon\Carbon;

class Transaction
{
    public function __construct(
        public ?int $payerId = null,
        public ?int $payeeId = null,
        public ?float $value = null,
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

    public function fromModel(TransactionModel $transactionModel): self
    {
        return new Transaction(
            payerId: $transactionModel['payer_id'],
            payeeId:  $transactionModel['payee_id'],
            value: $transactionModel['value'],
            status: $transactionModel['status'],
            updatedAt: $transactionModel['updated_at'],
            createdAt: $transactionModel['created_at'],
            id: $transactionModel['id']
        );
    }

    public function toModel(): TransactionModel
    {

        dd($this);
        return new TransactionModel([
            'payer_id' => $this->payerId,
            'payee_id' => $this->payeeId,
            'value' => $this->value,
            'status' => $this->status,
            'id' => $this->id
        ]);
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
