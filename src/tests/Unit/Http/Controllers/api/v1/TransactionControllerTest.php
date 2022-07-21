<?php

use App\Entities\Transaction;
use App\Http\Controllers\api\v1\TransactionController;
use App\Http\Requests\Transaction\CancelTransactionByToleranceTime;
use App\Http\Requests\Transaction\CancelTransactionRequest;
use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Tests\TestCase;


class TransactionControllerTest extends TestCase
{
    private TransactionService $transactionService;
    private TransactionController $transactionController;

    protected function setUp(): void
    {
        $this->transactionService = Mockery::mock(TransactionService::class);
        $this->transactionController = new TransactionController($this->transactionService);
        parent::setUp();
    }

    public function testStore()
    {
        // Arrange
        $request = new CreateTransactionRequest(['payer_id' => 1, 'payee_id' => 2, 'value' => 5]);

        $transaction = new Transaction(
            payerId: 1,
            payeeId: 2,
            value: 5,
            id: 1
        );

        $this->transactionService->shouldReceive('create')->andReturn($transaction);

        // Act
        $jsonResponse = $this->transactionController->store($request);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $jsonResponse);
        $this->assertEquals(Response::HTTP_CREATED, $jsonResponse->getStatusCode());
    }

    public function testCancel()
    {
        $request = new CancelTransactionRequest(['transaction_id' => 1]);

        $this->transactionService->shouldReceive('cancel')->andReturn();

        $jsonResponse = $this->transactionController->cancel($request);

        $this->assertInstanceOf(JsonResponse::class, $jsonResponse);
        $this->assertEquals(Response::HTTP_NO_CONTENT, $jsonResponse->getStatusCode());
    }

    public function testCancelByToleranceTime_whenTransactionTimeIsNotExceeded()
    {
        $request = new CancelTransactionByToleranceTime(['transaction_id' => 1]);

        $this->transactionService->shouldReceive('cancelByTimeTolerance')->andReturn(true);

        $jsonResponse = $this->transactionController->cancelByToleranceTime($request);

        $this->assertInstanceOf(JsonResponse::class, $jsonResponse);
        $this->assertEquals(Response::HTTP_NO_CONTENT, $jsonResponse->getStatusCode());
    }

    public function testCancelByToleranceTime_whenTransactionTimeIsExceeded()
    {
        $request = new CancelTransactionByToleranceTime(['transaction_id' => 1]);

        $this->transactionService->shouldReceive('cancelByTimeTolerance')->andReturn(false);

        $jsonResponse = $this->transactionController->cancelByToleranceTime($request);

        $this->assertInstanceOf(JsonResponse::class, $jsonResponse);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $jsonResponse->getStatusCode());
    }

    public function testShow()
    {
        $transactionId = 1;

        $transaction = new Transaction(
            payerId: 1,
            payeeId: 2,
            value: 5,
            id: 1
        );

        $this->transactionService->shouldReceive('findById')->andReturn($transaction);

        $jsonResponse = $this->transactionController->show($transactionId);

        $this->assertInstanceOf(JsonResponse::class, $jsonResponse);
        $this->assertEquals(Response::HTTP_OK, $jsonResponse->getStatusCode());
    }
}
