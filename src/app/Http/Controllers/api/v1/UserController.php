<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $users = User::all();
        return response()->json($users, 200);
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
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required',
            'cpf_cnpj' => 'required',
            'type'     => 'required',
        ];

        // Validation messages
        $messages = [
            'name.required'     => 'Name is required.',
            'email.required'    => 'Email is required.',
            'email.email'       => 'Invalid email.',
            'password.required' => 'Password is required.',
            'cpf_cnpj.required' => 'CPF or CNPJ is required.',
            'type.required'     => 'Type is required.'
        ];

        // Taking only the necessary data
        $requestData = $request->only(['name', 'email', 'password', 'cpf_cnpj', 'type']);

        // First parameter: Data to be validated
        // Second parameter: rules that will be applied
        // Third parameter: matching messages
        $validator = Validator::make($requestData, $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create($requestData);

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            $error = [
                'message' => 'User not found.'
            ];

            return response()->json($error, 400);
        }

        return response()->json($user, 200);
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
        $user = User::find($id);

        if (is_null($user)) {
            $error = [
                'message' => 'User not found.'
            ];

            return response()->json($error, 400);
        }

        $rules = [
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required',
            'cpf_cnpj' => 'required',
            'type'     => 'required',
        ];

        $messages = [
            'name.required'     => 'Name is required.',
            'email.required'    => 'Email is required.',
            'email.email'       => 'Invalid email.',
            'password.required' => 'Password is required.',
            'cpf_cnpj.required' => 'CPF or CNPJ is required.',
            'type.required'     => 'Type is required.'
        ];

        $requestData = $request->only(['name', 'email', 'password', 'cpf_cnpj', 'type']);

        $validator = Validator::make($requestData, $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user->update($requestData);

        return response()->json($user, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if(is_null($user)) {
            $error = [
                'message' => 'User not found.'
            ];

            return response()->json($error, 400);
        }

        $user->delete();

        return response()->json(null, 204);
    }
}
