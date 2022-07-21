<?php

use App\Entities\Transaction;
use App\Models\Transaction as TransactionModel;
use App\Repositories\Eloquent\TransactionRepository;
use Tests\TestCase;

class TransactionRepositoryTest extends TestCase
{
    private TransactionRepository $transactionRepository;
    private TransactionModel $transactionModel;

    protected function setUp(): void
    {
        $transactionEntity = Mockery::mock(Transaction::class);
        $this->transactionModel = Mockery::mock(TransactionModel::class);

        $this->transactionRepository = new TransactionRepository($transactionEntity);

        parent::setUp();
    }

    public function testFindById()
    {
        $transactionId = "1";

        $transactionModel = $this->transactionModel->shouldReceive('find')
            ->withArgs(['id', $transactionId])
            ->once()
            ->andReturnSelf();

        $return = $this->transactionRepository->findById($transactionId);

        $this->assertInstanceOf(TransactionModel::class, $transactionModel);
        $this->assertInstanceOf(Transaction::class, $return);
    }
}
