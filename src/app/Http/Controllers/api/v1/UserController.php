<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use GuzzleHttp\Exception\GuzzleException;
// use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        // Forma de usar os mocks
        $response = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
        return $response;
        // $users = User::all();
        // return response()->json($users, 200);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validating type
        $acceptableTypes = ['common', 'shopkeeper'];

        if (!in_array($request->type, $acceptableTypes)) {
            return response()->json(["message" => "User type must be common or shopkeeper."], 400);
        }

        // Validating CPF and CNPJ
        $userWithSameCpf = User::where('cpf_cnpj', $request->cpf_cnpj)->first();
        
        if ($userWithSameCpf) {
            return response()->json(["message" => "CPF or CNPJ is already in use."], 400);
        }

        $documentValidation = ($request->type == "common") ? $this->validateCpf($request->cpf_cnpj) : $this->validateCnpj($request->cpf_cnpj);

        if (!$documentValidation) {
            return response()->json(["message" => "CPF or CNPJ is invalid."], 400);
        }

        // Validating email
        $userWithSameEmail = User::where('email', $request->email)->first();

        if ($userWithSameEmail) {
            return response()->json(["message" => "Email is already in use."],400);
        }

        // Validation rulers
        $rules = [
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required',
            'cpf_cnpj' => 'required|numeric',
            'type'     => 'required',
        ];

        // Validation messages
        $messages = [
            'name.required'     => 'Name is required.',
            'email.required'    => 'Email is required.',
            'email.email'       => 'Invalid email.',
            'password.required' => 'Password is required.',
            'cpf_cnpj.required' => 'CPF or CNPJ is required.',
            'cpf_cnpj.numeric'  => 'CPF or CNPJ must be numeric.',
            'type.required'     => 'Type is required.'
        ];
        
        // Taking only the necessary data
        $requestData = $request->only(['name', 'email', 'password', 'cpf_cnpj', 'type']);
        
        // Hashing password
        $requestData['password'] = password_hash($request['password'], PASSWORD_DEFAULT);
        
        // First parameter:  Data to be validated
        // Second parameter: Rules that will be applied
        // Third parameter:  Matching messages
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
