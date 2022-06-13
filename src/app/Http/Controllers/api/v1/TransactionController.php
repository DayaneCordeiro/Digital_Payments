<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\Transaction\CancelTransactionByUserRequest;
use App\Http\Requests\Transaction\CancelTransactionRequest;
use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Services\TransactionService;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\User;
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
     * @return JsonResponse|void
     */
    public function store(CreateTransactionRequest $request)
    {
        try {
            /**
             * Jogar os mocks para repositories
             * Tirar todos os models do controller
             *  Controller -> Mapeia a entidade -> Service -> Repository
             *  Não esquecer dos providers
             */

            $transaction = $this->transactionService->create($request);

            $requestData = $request->only(["payer_id", "payee_id", "value"]);

            $externalAuthorization = Http::get("https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6"); // AuthorizationRepository : authorize(): bool

            if ($externalAuthorization["message"] == "Autorizado") {
                $requestData["status"] = "approved";
            } else {
                $requestData["status"] = "not-approved";
            }

            $transaction = Transaction::create($requestData);

            if ($transaction) {
                $emailConfirmation = Http::get("http://o4d9z.mocklab.io/notify");

                $payer = User::find($request->payer_id);
                $payee = User::find($request->payee_id);

                $payer_wallet = Wallet::where("user_id", $payer->id)->first();
                $payee_wallet = Wallet::where("user_id", $payee->id)->first();

                if ($emailConfirmation["message"] == "Success") {
                    // Subtract value from payer wallet
                    $subtractionValue = $payer_wallet->balance - $request->value;
                    $payer_wallet->update(["balance" => $subtractionValue]);

                    // Add value to payee wallet
                    $additionValue = $payee_wallet->balance + $request->value;
                    $payee_wallet->update(["balance" => $additionValue]);
                } else {
                    $transaction->update(["status" => "not-approved"]);
                    $error = ["message" => "The transaction could not be completed because the notifications service is down, please try again later."];
                    return response()->json($error, Response::HTTP_BAD_REQUEST);
                }

                return response()->json($transaction, Response::HTTP_CREATED);
            }
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
            // Validates transaction
            $transaction  = Transaction::find($request->transaction_id);

            $payee_wallet = Wallet::where("user_id", $transaction->payee_id)->first();
            $payer_wallet = Wallet::where("user_id", $transaction->payer_id)->first();

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
            $transaction = Transaction::find($id);

            if (is_null($transaction)) {
                $error = ['message' => 'Transaction not found.'];
                return response()->json($error, 400);
            }

            return response()->json($transaction, 200);
        } catch(Exception $e) {
            return response()->json(["Message" => $e->getMessage()], 502);
        }
    }
}
