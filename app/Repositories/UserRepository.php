<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserRepository
{

    /** create or update User */
    public function   save(array $data)
    {
        try {

            $user =  User::updateOrcreate(["id" => $data['id'] ?? null], $data);

            if ($user) {
                return  $user;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            Log::error("errors", [
                "error" => $th->getMessage(),
                "line" => $th->getLine(),
                "file" => $th->getFile()
            ], 500);
        }
    }

    /** Find User */
    public function find(?int $id = null, ?string $email = null)
    {
        try {
            $query =  User::query();


            if (!empty($id) and !empty($email)) {
                $user = $query->where("id", $id)
                    ->where("email", $email)
                    ?->first($id);


                return $user;
            }

            if (!empty($id) and empty($email)) {
                $user = $query?->findOrFail($id);


                return $user;
            }


            if (empty($id) and !empty($email)) {
                $user = $query?->where("email", $email)?->first();
                return $user;
            }


            return null;
        } catch (\Throwable $th) {
            Log::error("errors", [
                "error" => $th->getMessage(),
                "line" => $th->getLine()
            ]);
        }
    }

    /** Destroy User */
    public function   destroy(int $id)
    {
        try {
            $user =  User::findOrFail($id);

            if ($user) {
                return  $user->delete();
            }
            return null;
        } catch (\Throwable $th) {
            Log::error("errors", [
                "error" => $th->getMessage(),
                "line" => $th->getLine()
            ]);
        }
    }
}
