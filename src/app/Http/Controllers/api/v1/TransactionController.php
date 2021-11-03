<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;

class TransactionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $payer = User::find($request->payer_id);
            $payee = User::find($request->payee_id);
            
            // Checks if payer exists, it's common type and if it'a active
            if (!$payer) {
                $error = ["message" => "Payer not found."];
                return response()->json($error, 400);
            } else if ($payer->type != "common") {
                $error = ["message" => "Payer must be common type."];
                return response()->json($error, 400);
            } else if ($payer->status != "active") {
                $error = ["message" => "This payer is inactive and cannot complete the transaction."];
                return response()->json($error, 400);
            }
            
            // Checks if payee exists and if it'a active
            if (!$payee) {
                $error = ["message" => "Payee not found."];
                return response()->json($error, 400);
            } else if ($payee->status != "active") {
                $error = ["message" => "This payee is inactive and cannot receive the transaction."];
                return response()->json($error, 400);
            }
            
            // Check if the payer is equal to the payee
            if ($payer->id == $payee->id) {
                $error = ["message" => "It is not possible to make a transaction for yourself.."];
                return response()->json($error, 400);
            }

            // Checks if payer password is correct
            $requestPayerPassword = md5($request->password);

            if ($requestPayerPassword != $payer->password) {
                $error = ["message" => "Incorrect password."];
                return response()->json($error, 400);
            }

            $payer_wallet = Wallet::where("user_id", $payer->id)->first();
            $payee_wallet = Wallet::where("user_id", $payee->id)->first();
            
            // Checks if payer_wallet exists and has the necessary value
            if (!$payer_wallet) {
                $error = ["message" => "Payer wallet not found."];
                return response()->json($error, 400);
            } else if ($payer_wallet->balance < $request->value) {
                $error = ["message" => "Insufficient balance to complete transaction."];
                return response()->json($error, 400);
            }

            // Checks if payee_wallet exists
            if (!$payee_wallet) {
                $error = ["message" => "Payee wallet not found."];
                return response()->json($error, 400);
            }

            // Validation rulers -> talvez fazer tudo manualmente vide documentação salva nos favoritos
            $rules = [
                "payer_id" => "required",
                "payee_id" => "required",
                "value"    => "required",
                "password" => "required"
            ];

            // Validation messages
            $messages = [
                "payer_id.required" => "payer_id is required.",
                "payee_id.required" => "payee_id is required.",
                "value.required"    => "value is required.",
                "password.required" => "Password of the payer is required.",
            ];

            // Taking only the necessary data
            $requestData = $request->only(["payer_id", "payee_id", "value", "password"]);

            // First parameter:  Data to be validated
            // Second parameter: Rules that will be applied
            // Third parameter:  Matching messages
            $validator = Validator::make($requestData, $rules, $messages);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // Checks if transaction is authorized by external service
            $externalAuthorization = Http::get("https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6");

            if ($externalAuthorization["message"] == "Autorizado") {
                $requestData["status"] = "approved";
            } else {
                $requestData["status"] = "not-approved";
            }

            $transaction = Transaction::create($requestData);

            if ($transaction) {
                // Checks if email was send
                $emailConfirmation = Http::get("http://o4d9z.mocklab.io/notify");

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
                    return response()->json($error, 400);
                }

                return response()->json($transaction, 201);
            }            
        } catch(Exception $e) {
            return response()->json(["Message" => $e->getMessage()], 502);
        }
    }

    /**
     * Cancel the specified transaction.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Respons
     */
    public function cancel(Request $request)
    {
        try {
            // Validates transaction
            $transaction  = Transaction::find($request->id);
            
            if (is_null($transaction)) {
                $error = ["message" => "Transaction not found."];
                return response()->json($error, 400);
            }

            $payee_wallet = Wallet::where("user_id", $transaction->payee_id)->first();
            $payer_wallet = Wallet::where("user_id", $transaction->payer_id)->first();

            // Checks if payee has balance
            if ($payee_wallet->balance < $transaction->value) {
                $error = ["message" => "Insufficient balance to complete the operation."];
                return response()->json($error, 400);
            }    
    
            if ($transaction->status === "canceled") {
                $error = ["message" => "Transaction is already canceled."];
                return response()->json($error, 400);
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
     * Cancel the specified transaction.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Respons
     */
    public function cancelByUser(Request $request)
    {
        try {
            // Validates transaction
            $transaction  = Transaction::find($request->id);
            
            if (is_null($transaction)) {
                $error = ["message" => "Transaction not found."];
                return response()->json($error, 400);
            }

            $payee_wallet = Wallet::where("user_id", $transaction->payee_id)->first();
            $payer_wallet = Wallet::where("user_id", $transaction->payer_id)->first();

            // Checks if payee has balance
            if ($payee_wallet->balance < $transaction->value) {
                $error = ["message" => "Insufficient balance to complete the operation."];
                return response()->json($error, 400);
            }    
    
            if ($transaction->status === "canceled") {
                $error = ["message" => "Transaction is already canceled."];
                return response()->json($error, 400);
            }

            // Validation rulers
            $rules = [
                "user_id" => "required",
                "id" => "required"
            ];

            // Validation messages
            $messages = [
                "user_id.required" => "User id is required.",
                "id.required" => "Transaction id is required."
            ];
            
            // Taking only the necessary data
            $requestData = $request->only(["user_id", "id"]);

            // First parameter:  Data to be validated
            // Second parameter: Rules that will be applied
            // Third parameter:  Matching messages
            $validator = Validator::make($requestData, $rules, $messages);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
