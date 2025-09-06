<?php

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthRepository
{

    /** Login */
    public static  function login(string $email, string $password)
    {

        try {
            $user = User::where('email', $email)->first();

            if (! $user || ! Hash::check($password, $user->password)) {
                return ['error' => 'Credenciais inválidas'];
            }

            $token = $user->createToken('api_token')->plainTextToken;

            return [
                'message' => 'Login efetuado com sucesso',
                'token'   => $token,
                'user'    => new UserResource($user),
            ];
        } catch (\Throwable $th) {
            Log::error("errors", [
                "error" => $th->getMessage(),
                "line"  => $th->getLine()
            ]);
        }
    }

    /** Logout */
    public static function logout($user)
    {
        try {
            // Apaga todos os tokens do utilizador
            $deleted = $user->tokens()->delete();

            if (! $deleted) {
                return ['message' => 'Falha ao fazer Logout'];
            }

            return ['message' => 'Sessão terminada'];
        } catch (\Throwable $th) {
            Log::error("errors", [
                "error" => $th->getMessage(),
                "line"  => $th->getLine()
            ]);

            return ['message' => 'Falha ao fazer Logout'];
        }
    }
}
