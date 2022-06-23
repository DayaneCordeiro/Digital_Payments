<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\Transaction\CancelTransactionByUserRequest;
use App\Http\Requests\Transaction\CancelTransactionRequest;
use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Services\TransactionService;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\Wallet;
use Symfony\Component\HttpFoundation\Response;

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
            $transaction = $this->transactionService->create($request);

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
     * @param CancelTransactionByUserRequest $request
     * @return JsonResponse
     */
    public function cancelByUser(CancelTransactionByUserRequest $request)
    {
        try {
            // Validates transaction
            $transaction  = Transaction::find($request->transaction_id);

            $payee_wallet = Wallet::where("user_id", $transaction->payee_id)->first();
            $payer_wallet = Wallet::where("user_id", $transaction->payer_id)->first();

            // Taking only the necessary data
            $requestData = $request->only(["user_id", "id"]);

            // Checks who is trying to cancel the transaction and treat
            if ($request->user_id == $transaction->payer_id) {
                // Creating a tolerance of five minutes for the payer to cancel
                $transactionTime = new Carbon($transaction->created_at);
                $now = Carbon::now();

                $timeDifference = $now->diffInMinutes($transactionTime);

                if ($timeDifference > 5) {
                    $error = ["message" => "Cancellation tolerance time exceeded, please contact the bank."];
                    return response()->json($error, 400);
                }
            }

            $transaction->update(["status" => "canceled"]);

            // Subtract value from payee wallet
            $subtractionValue = $payee_wallet->balance - $transaction->value;
            $payee_wallet->update(["balance" => $subtractionValue]);

            // Add value to payer wallet
            $additionValue = $payer_wallet->balance + $transaction->value;
            $payer_wallet->update(["balance" => $additionValue]);

            return response()->json(null, 204);
        } catch(Exception $e) {
            return response()->json(["Message" => $e->getMessage()], 502);
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
