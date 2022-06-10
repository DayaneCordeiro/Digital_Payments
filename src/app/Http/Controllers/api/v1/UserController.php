<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\User\CreateUserRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;

class UserController extends Controller
{
    /**
     * @param CreateUserRequest $request
     * @return JsonResponse|void
     */
    public function store(CreateUserRequest $request)
    {
        try {
            // Taking only the necessary data
            $requestData = $request->only(["name", "email", "password", "document", "type", "status"]);

            // Hashing password
            $requestData["password"] = md5($request["password"]);

            $user = User::create($requestData);

            // Creating user wallet
            if ($user) {
                $wallet = Http::post('http://nginx/api/v1/wallets', [
                    "user_id" => $user->id,
                    "balance" => 0,
                    "status"  => "active"
                ]);

                return response()->json($user, 201);
            }
        } catch (Exception $e) {
            return response()->json(["Message" => $e->getMessage()], 502);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function inactive(Request $request)
    {
        try {
            $user = User::find($request->id);

            if (is_null($user)) {
                $error = ["message" => "User not found."];
                return response()->json($error, 400);
            }

            if ($user->status !== "active") {
                $error = ["message" => "User is already inactive."];
                return response()->json($error, 400);
            }

            $user->update(["status" => "inactive"]);

            // Inactive user's wallet
            $wallet = Wallet::where("user_id", $request->id)->first();

            Http::put('http://nginx/api/v1/wallets_inactive', [
                "id" => $wallet->id
            ]);

            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json(["Message" => $e->getMessage()], 502);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function active(Request $request)
    {
        try {
            $user = User::find($request->id);

            if (is_null($user)) {
                $error = ["message" => "User not found."];
                return response()->json($error, 400);
            }

            if ($user->status !== "inactive") {
                $error = ["message" => "User is already active."];
                return response()->json($error, 400);
            }

            $user->update(["status" => "active"]);

            // Active user's wallet
            $wallet = Wallet::where("user_id", $request->id)->first();

            Http::put('http://nginx/api/v1/wallets_active', [
                "id" => $wallet->id
            ]);

            return response()->json(null, 204);
        } catch (Exception $e) {
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
            $user = User::find($id);

            if (is_null($user)) {
                $error = ["message" => "User not found."];
                return response()->json($error, 400);
            }

            return response()->json($user, 200);
        } catch (Exception $e) {
            return response()->json(["Message" => $e->getMessage()], 502);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            // Validating user
            $user = User::find($id);

            if (is_null($user)) {
                $error = ["message" => "User not found."];
                return response()->json($error, 400);
            }

            // Validating type
            $acceptableTypes = ["common", "shopkeeper"];

            if (isset($request->type) && !in_array($request->type, $acceptableTypes)) {
                $error = ["message" => "User type must be common or shopkeeper."];
                return response()->json($error, 400);
            }

            // Validating status
            $acceptableStatus = ["active", "inactive"];

            if (isset($request->status) && !in_array($request->status, $acceptableStatus)) {
                $error = ["message" => "User status must be active or inactive."];
                return response()->json($error, 400);
            }

            // Validating CPF and CNPJ
            $documentValidation = ($request->type == "common") ? $this->validateCpf($request->cpf_cnpj) : $this->validateCnpj($request->cpf_cnpj);

            if (!$documentValidation) {
                $error = ["message" => "CPF or CNPJ is invalid."];
                return response()->json($error, 400);
            }

            $rules = [
                "name"     => "required",
                "email"    => "required|email",
                "password" => "required",
                "cpf_cnpj" => "required",
                "type"     => "required",
            ];

            $messages = [
                "name.required"     => "Name is required.",
                "email.required"    => "Email is required.",
                "email.email"       => "Invalid email.",
                "password.required" => "Password is required.",
                "cpf_cnpj.required" => "CPF or CNPJ is required.",
                "type.required"     => "Type is required."
            ];

            $requestData = $request->only(["name", "email", "password", "cpf_cnpj", "type"]);

            // Hashing password
            $requestData["password"] = md5($request["password"]);

            $validator = Validator::make($requestData, $rules, $messages);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $user->update($requestData);

            return response()->json($user, 201);
        } catch (Exception $e) {
            return response()->json(["Message" => $e->getMessage()], 502);
        }
    }
}
