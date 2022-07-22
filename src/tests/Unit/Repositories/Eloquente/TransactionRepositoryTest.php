<?php

use App\Entities\Transaction;
use App\Models\Transaction as TransactionModel;
use App\Repositories\Eloquent\TransactionRepository;
use Tests\TestCase;

class TransactionRepositoryTest extends TestCase
{
    private TransactionRepository $transactionRepository;
    private TransactionModel $transactionModel;
    private Transaction $transaction;

    protected function setUp(): void
    {
        $this->transaction = Mockery::mock(Transaction::class);

        $this->transactionModel = Mockery::mock(TransactionModel::class);

        $this->transactionRepository = new TransactionRepository($this->transactionModel);

        parent::setUp();
    }

    public function transactionArrayFake(): array
    {
        return [
            'payer_id' => 1,
            'payee_id' => 2,
            'value' => 50,
            'status' => 'approved',
            'updated_at' => '2022-07-22T16:37:03.000000Z',
            'created_at' => '2022-07-22T16:37:03.000000Z',
            'id' => 1
        ];
    }

    public function testCreate()
    {
        $transaction = new Transaction(
            payerId: 1,
            payeeId: 2,
            value: 50,
        );

        $this->transactionModel->shouldReceive('create')
            ->with($transaction->toArray())
            ->once()
            ->andReturnSelf();

        $this->transaction->shouldReceive('fromArray')->andReturnSelf();

        $this->transactionModel->shouldReceive('toArray')
            ->andReturn($this->transactionArrayFake());

        $return = $this->transactionRepository->create($transaction);

        $this->assertNotEmpty($return);
        $this->assertInstanceOf(Transaction::class, $return);
    }

    public function testFindById()
    {
        $this->transactionModel->shouldReceive('find')
            ->with(1)
            ->once()
            ->andReturnSelf();

        $this->transaction->shouldReceive('fromArray')->andReturnSelf();

        $this->transactionModel->shouldReceive('toArray')
            ->andReturn($this->transactionArrayFake());

        $return = $this->transactionRepository->findById(1);

        $this->assertNotEmpty($return);
        $this->assertInstanceOf(Transaction::class, $return);
    }

    public function testUpdateStatus()
    {
        $transaction = new Transaction(
            payerId: 1,
            payeeId: 2,
            value: 50,
            id: 1
        );

        $this->transactionModel->shouldReceive('find')
            ->with(1)
            ->once()
            ->andReturnSelf();

        $this->transactionModel->shouldReceive('update')
            ->andReturn();

        $this->transactionRepository->updateStatus($transaction, 'canceled');
    }
}
