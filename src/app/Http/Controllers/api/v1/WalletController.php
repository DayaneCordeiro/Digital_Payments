<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Wallet;
use App\Models\User;

class WalletController extends Controller
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
            $user = User::find($request->user_id);

            // Checks if user exists
            if (!$user) {
                $error = ["message" => "User not found."];
                return response()->json($error, 400);
            }

            // Validation rulers -> talvez fazer tudo manualmente vide documentação salva nos favoritos
            $rules = [
                'user_id' => 'required',
                'balance' => 'required|numeric',
                'status'  => 'required'
            ];

            // Validation messages
            $messages = [
                'user_id.required' => 'User id is required.',
                'balance.required' => 'Balance is required.',
                'balance.numeric'  => 'Balance must be numeric.',
                'status.required'  => 'Status is required.'
            ];

            // Taking only the necessary data
            $requestData = $request->only(['user_id', 'balance', 'status']);

            // First parameter: Data to be validated
            // Second parameter: rules that will be applied
            // Third parameter: matching messages
            $validator = Validator::make($requestData, $rules, $messages);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $wallet = Wallet::create($requestData);

            return response()->json($wallet, 201);
        } catch(Exception $e) {
            return response()->json(["Message" => $e->getMessage()], 502);
        }        
    }

    /**
     * Inactive the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function inactive(Request $request) {
        $wallet = Wallet::find($request->id);

        if (is_null($wallet)) {
            $error = ["message" => "Wallet not found."];
            return response()->json($error, 400);
        }

        if ($wallet->status !== "active") {
            $error = ["message" => "Wallet is already inactive."];
            return response()->json($error, 400);
        }

        $wallet->update(["status" => "inactive"]);

        return response()->json(null, 204);
    }

    /**
     * Active the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function active(Request $request) {
        $wallet = Wallet::find($request->id);

        if (is_null($wallet)) {
            $error = ["message" => "Wallet not found."];
            return response()->json($error, 400);
        }

        if ($wallet->status !== "inactive") {
            $error = ["message" => "Wallet is already active."];
            return response()->json($error, 400);
        }

        $wallet->update(["status" => "active"]);

        return response()->json(null, 204);
    }

    /**
     * Insert money to the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deposite(Request $request)
    {
        try {
            $wallet = Wallet::find($request->id);

            // Checks if wallet exists
            if (!$wallet) {
                $error = ["message" => "Wallet not found."];
                return response()->json($error, 400);
            }

            $additionValue = $request->value + $wallet->balance;
            $wallet->update(["balance" => $additionValue]);

            return response()->json($wallet, 201);
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
            $wallet = Wallet::find($id);
    
            if (is_null($wallet)) {
                $error = ['message' => 'wallet not found.'];
                return response()->json($error, 400);
            }
    
            return response()->json($wallet, 200);
        } catch(Exception $e) {
            return response()->json(["Message" => $e->getMessage()], 502);
        }  
    }
}
