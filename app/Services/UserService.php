<?php

namespace App\Services;

use App\Http\Requests;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Log;

class UserService
{
    public array $rules;
    public function __construct(array $rules)
    {
        $this->rules = (new  UserRequest())->rules();
    }
    public static function rules(): array
    {


        try {
            return self::$rules;
        } catch (\Throwable $th) {
            Log::error("errors", [
                "error" => $th->getMessage(),
                "line" => $th->getLine()
            ]);
        }
    }
}
