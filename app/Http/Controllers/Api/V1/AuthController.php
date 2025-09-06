<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Repositories\AuthRepository;
use App\Services\CandidateProgramService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Login.
     */
    public function login(LoginRequest $request)
    {
        try {
            $login = AuthRepository::login($request->email, $request->password);

            if (isset($login['error'])) {
                return response()->json([
                    "error" => "Email ou Senha Invalida.",
                ], 401);
            }


            return response()->json([
                'message' => 'Login efetuado com sucesso',
                'token'   => $login['token'],
                'user'    => $login['user'],
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "Falha ao realizar operação.",
                "data" => $th->getMessage(),
            ], 500);
        }
    }




    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        try {
            $logout = AuthRepository::logout($request->user());
            return response()->json([
                "error" => $logout['message'],
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "Falha ao realizar operação.",
                "data" => $th->getMessage(),
                "line"=>$th->getLine()
            ], 500);
        }
    }
}
