<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            $data = $data = $request->validated();
            if ($request->filled('id')) {
                $data['id'] = $request->id;
            }

            $user = (new UserRepository())->save($data);

            if (!$user) {
                return response()->json([
                    "error" => "Falha ao cria conta.",
                ], 500);
            }

            $token = null;
            $message = null;
            if (!isset($data['id'])) {

                // gera token Sanctum
                $token = $user->createToken('auth_token')->plainTextToken;
                $message = "Conta criada com sucesso";
            }

            return response()->json([
                "message" => $message ?? "Conta actualizada com sucesso.",
                "user" => new UserResource($user),
                "token" => $token
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "Falha ao criar conta.",
                "data" => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {

            $user = (new UserRepository())->find($request->id, $request->email);

            if (!$user) {
                return response()->json([
                    "error" => "Utilizador não encontrado.",
                ], 404);
            }

            return response()->json([
                "user" => new UserResource($user),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "Falha ao bsucar conta.",
                "data" => $th->getMessage(),
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $user = (new UserRepository())->destroy($request->id);
            if (!$user) {
                return response()->json([
                    "error" => "Utilizador não encontrado.",
                ], 404);
            }

            return response()->json([
                "user" => new UserResource($user),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "Falha ao criar conta.",
            ]);
        }
    }
}
