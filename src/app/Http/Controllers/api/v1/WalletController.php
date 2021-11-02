<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Wallet;
use App\Models\User;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallets = Wallet::all();
        return response()->json($wallets, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation rulers -> talvez fazer tudo manualmente vide documentação salva nos favoritos
        $rules = [
            'user_id' => 'required',
            'balance' => 'required',
            'status'  => 'required'
        ];

        // Validation messages
        $messages = [
            'user_id.required' => 'user_id is required.',
            'balance.required' => 'balance is required.',
            'status.required'  => 'status is required.'
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wallet = Wallet::find($id);

        if (is_null($wallet)) {
            $error = [
                'message' => 'wallet not found.'
            ];

            return response()->json($error, 400);
        }

        return response()->json($wallet, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $wallet = Wallet::find($id);

        if (is_null($wallet)) {
            $error = [
                'message' => 'Wallet not found.'
            ];

            return response()->json($error, 400);
        }

        // Validation rulers -> talvez fazer tudo manualmente vide documentação salva nos favoritos
        $rules = [
            'user_id' => 'required',
            'balance' => 'required',
            'status'  => 'required'
        ];

        // Validation messages
        $messages = [
            'user_id.required' => 'user_id is required.',
            'balance.required' => 'balance is required.',
            'status.required'  => 'status is required.'
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

        $wallet->update($requestData);

        return response()->json($wallet, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wallet = Wallet::find($id);

        if(is_null($wallet)) {
            $error = [
                'message' => 'Wallet not found.'
            ];

            return response()->json($error, 400);
        }

        $wallet->delete();

        return response()->json(null, 204);
    }
}
