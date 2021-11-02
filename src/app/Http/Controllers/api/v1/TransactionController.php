<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Transaction;
use App\Models\User;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json($transactions, 200);
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
            'payer_id' => 'required',
            'payee_id' => 'required',
            'value'    => 'required',
            'status'   => 'required'
        ];

        // Validation messages
        $messages = [
            'payer_id.required' => 'payer_id is required.',
            'payee_id.required' => 'payee_id is required.',
            'value.required'    => 'value is required.',
            'status.required'   => 'status is required.',
        ];

        // Taking only the necessary data
        $requestData = $request->only(['payer_id', 'payee_id', 'value', 'status']);

        // First parameter: Data to be validated
        // Second parameter: rules that will be applied
        // Third parameter: matching messages
        $validator = Validator::make($requestData, $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $transaction = Transaction::create($requestData);

        return response()->json($transaction, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::find($id);

        if (is_null($transaction)) {
            $error = [
                'message' => 'Transaction not found.'
            ];

            return response()->json($error, 400);
        }

        return response()->json($transaction, 200);
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
        $transaction = Transaction::find($id);

        if (is_null($transaction)) {
            $error = [
                'message' => 'Transaction not found.'
            ];

            return response()->json($error, 400);
        }

        // Validation rulers -> talvez fazer tudo manualmente vide documentação salva nos favoritos
        $rules = [
            'payer_id' => 'required',
            'payee_id' => 'required',
            'value'    => 'required',
            'status'   => 'required'
        ];

        // Validation messages
        $messages = [
            'payer_id.required' => 'payer_id is required.',
            'payee_id.required' => 'payee_id is required.',
            'value.required'    => 'value is required.',
            'status.required'   => 'status is required.',
        ];

        // Taking only the necessary data
        $requestData = $request->only(['payer_id', 'payee_id', 'value', 'status']);

        // First parameter: Data to be validated
        // Second parameter: rules that will be applied
        // Third parameter: matching messages
        $validator = Validator::make($requestData, $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $transaction->update($requestData);

        return response()->json($transaction, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if(is_null($transaction)) {
            $error = [
                'message' => 'Transaction not found.'
            ];

            return response()->json($error, 400);
        }

        $transaction->delete();

        return response()->json(null, 204);
    }
}
