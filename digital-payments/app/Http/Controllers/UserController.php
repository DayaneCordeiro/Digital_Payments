<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\User;

class UserController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getUser($id) {
        // to do
    }

    public function createUser(Request $request) {
        print_r($request);

        $user           = new User;
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->cpf      = $request->cpf;
        $user->password = $request->password;
        $user->type     = $request->type;
        $user->status   = $request->status;
        $user->created_at = now();

        echo "teste"; die();

        // Tratar os dados aqui
        $user->save();

        return response()->json([
            "message" => "user created successfully"
        ], 201);
    }

    public function deleteUser($id) {
        // to do
    }
}

