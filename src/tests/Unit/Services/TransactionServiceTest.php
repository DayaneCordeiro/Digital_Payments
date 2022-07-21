<?php

use App\Entities\Transaction;
use App\Repositories\AuthorizationRepository;
use App\Repositories\SendEmailRepository;
use App\Repositories\TransactionRepositoryInterface;
use App\Services\TransactionService;
use App\Services\WalletService;
use Carbon\Carbon;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    private TransactionService $transactionService;
    private TransactionRepositoryInterface $transactionRepository;
    private AuthorizationRepository $authorizationRepository;
    private SendEmailRepository $sendEmailRepository;
    private WalletService $walletService;

    /**
     * @param Transaction $transaction
     * @param int $transactionId
     * @return bool
     */
    public function getReturn(Transaction $transaction, int $transactionId): bool
    {
        $this->transactionRepository->shouldReceive('findById')->andReturn($transaction);

        $this->transactionRepository->shouldReceive('findById')->andReturn($transaction);

        $this->walletService->shouldReceive('subtractValueFromWallet')->andReturn();

        $this->walletService->shouldReceive('addValueFromWallet')->andReturn();

        $this->transactionRepository->shouldReceive('updateStatus')->andReturn();

        return $this->transactionService->cancelByTimeTolerance($transactionId);
    }

    protected function setUp(): void
    {
        $this->transactionRepository = Mockery::mock(TransactionRepositoryInterface::class);
        $this->authorizationRepository = Mockery::mock(AuthorizationRepository::class);
        $this->sendEmailRepository = Mockery::mock(SendEmailRepository::class);
        $this->walletService = Mockery::mock(WalletService::class);

        $this->transactionService = new TransactionService(
            $this->transactionRepository,
            $this->authorizationRepository,
            $this->sendEmailRepository,
            $this->walletService
        );

        parent::setUp();
    }

    public function testCreate()
    {
        // Arrange
        $transaction = new Transaction(
            payerId: 1,
            payeeId: 2,
            value: 5,
            id: 1
        );

        $this->authorizationRepository->shouldReceive('authorize')->andReturn('approved');

        $this->transactionRepository->shouldReceive('create')->andReturn($transaction);

        $this->sendEmailRepository->shouldReceive('sendEmail')->andReturn();

        $this->walletService->shouldReceive('subtractValueFromWallet')->andReturn();

        $this->walletService->shouldReceive('addValueFromWallet')->andReturn();

        // Act
        $return = $this->transactionService->create($transaction);

        // Assert
        $this->assertNotEmpty($return);
        $this->assertInstanceOf(Transaction::class, $return);
    }

    public function testCancel()
    {
        $transactionId = 1;

        $transaction = new Transaction(
            payerId: 1,
            payeeId: 2,
            value: 5,
            id: 1
        );

        $this->transactionRepository->shouldReceive('findById')->andReturn($transaction);

        $this->walletService->shouldReceive('subtractValueFromWallet')->andReturn();

        $this->walletService->shouldReceive('addValueFromWallet')->andReturn();

        $this->transactionRepository->shouldReceive('updateStatus')->andReturn();

        $this->transactionService->cancel($transactionId);
    }

    public function testFindBy()
    {
        $transactionId = 1;

        $transaction = new Transaction(
            payerId: 1,
            payeeId: 2,
            value: 5,
            id: 1
        );

        $this->transactionRepository->shouldReceive('findById')->andReturn($transaction);

        $return = $this->transactionService->findById($transactionId);

        $this->assertNotEmpty($return);
        $this->assertInstanceOf(Transaction::class, $return);
    }

    public function testCancelByTimeTolerance_whenTimeToleranceIsNotExceeded()
    {
        $transactionId = 1;

        $transaction = new Transaction(
            payerId: 1,
            payeeId: 2,
            value: 5,
            createdAt: Carbon::now(),
            id: 1
        );

        $return = $this->getReturn($transaction, $transactionId);

        $this->assertTrue($return);
    }

    public function testCancelByTimeTolerance_whenTimeToleranceIsExceeded()
    {
        $transactionId = 1;

        $transaction = new Transaction(
            payerId: 1,
            payeeId: 2,
            value: 5,
            createdAt: new Carbon("2022-07-21T17:56:50.000000Z"),
            id: 1
        );

        $return = $this->getReturn($transaction, $transactionId);

        $this->assertFalse($return);
    }
}
