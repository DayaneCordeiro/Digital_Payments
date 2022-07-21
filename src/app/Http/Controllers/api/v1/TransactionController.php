<?php

namespace App\Http\Controllers\api\v1;

use App\Entities\Transaction;
use App\Http\Requests\Transaction\CancelTransactionByToleranceTime;
use App\Http\Requests\Transaction\CancelTransactionRequest;
use App\Http\Requests\Transaction\CreateTransactionRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Services\TransactionService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Exception;

class TransactionController extends Controller
{
    public function __construct(
        public TransactionService $transactionService
    ) {
    }

    /**
     * @param CreateTransactionRequest $request
     * @return JsonResponse
     */
    public function store(CreateTransactionRequest $request)
    {
        try {
            $transaction = new Transaction(
                payerId: $request->get('payer_id'),
                payeeId: $request->get('payee_id'),
                value: $request->get('value')
            );

            $transaction = $this->transactionService->create($transaction);

            return response()->json($transaction, Response::HTTP_CREATED);
        } catch(Exception $e) {
            return response()->json(["Message" => $e->getMessage()], Response::HTTP_BAD_GATEWAY);
        }
    }

    /**
     * @param CancelTransactionRequest $request
     * @return JsonResponse
     */
    public function cancel(CancelTransactionRequest $request)
    {
        try {
            $this->transactionService->cancel($request->transaction_id);

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch(Exception $e) {
            return response()->json(["Message" => $e->getMessage()], Response::HTTP_BAD_GATEWAY);
        }
    }

    /**
     * @param CancelTransactionByToleranceTime $request
     * @return JsonResponse
     */
    public function cancelByToleranceTime(CancelTransactionByToleranceTime $request)
    {
        try {
            $response = $this->transactionService->cancelByTimeTolerance($request->transaction_id);

            if ($response) {
                return response()->json(null, Response::HTTP_NO_CONTENT);
            }

            return response()->json(
                [
                    'Message' => 'Cancellation tolerance time exceeded, please contact the bank.'
                ],
                Response::HTTP_BAD_REQUEST);
        } catch(Exception $e) {
            return response()->json(["Message" => $e->getMessage()], Response::HTTP_BAD_GATEWAY);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $transaction = $this->transactionService->findById($id);

            return response()->json($transaction, Response::HTTP_OK);
        } catch(Exception $e) {
            return response()->json(["Message" => $e->getMessage()], Response::HTTP_BAD_GATEWAY);
        }
    }
}
