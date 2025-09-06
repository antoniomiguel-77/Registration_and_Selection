<?php

namespace App\Repositories;

use App\Models\CandidateProgram;
use App\Models\Program;
use App\Models\User;
use App\Services\CandidateProgramService;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class CandidateProgramRepository
{




    /**  Candidatar-se */
    public static function store(int $programId, User $user)
    {
        try {
            $program = Program::findOrFail($programId);

            if (!CandidateProgramService::canApply($program)) {


                return [
                    "status" => false,
                    "message" => "As candidaturas para este programa não estão abertas."
                ];
            }


            /** Criar a candidatura */
            $isTrue = self::saveApplication($user->id, $program);

            if (!$isTrue) {
                return [
                    "status" => false,
                    "message" => "Não foi possivel efetuar a candidatura."
                ];
            };

            return [
                "status" => true,
                "message" => "Sr(a), ".$user->name." sua candidatura foi Efetuada com sucesso."
            ];
        } catch (\Throwable $th) {
            Log::error("errors", [
                "error" => $th->getMessage(),
                "line" => $th->getLine()
            ]);
        }
    }



    /** Setar a candidatura */

    private static function saveApplication(int $user, Program $program)
    {
        try {


            return  CandidateProgram::create([
                "user_id" => $user,
                "program_id" => $program->id
            ]);
            /** Criar a candidatura */
        } catch (\Throwable $th) {
            Log::error("errors", [
                "error" => $th->getMessage(),
                "line" => $th->getLine()
            ]);
        }
    }


    /** Listar candidaturas do utilizador */
    public static function getApplication(?int $user = null, ?int $program = null)
    {
        try {
            $query = CandidateProgram::query()
                ->with(['user', 'program']); // já carrega relações

            if ($user) {
                $query->where('user_id', $user);
            }

            if ($program) {
                $query->where('program_id', $program);
            }

            return $query->get();
        } catch (\Throwable $th) {
            Log::error("errors", [
                "error" => $th->getMessage(),
                "line"  => $th->getLine()
            ]);

            return collect(); // retorna vazio em caso de erro
        }
    }


    /** Cancelar candidaturas do utilizador */
    public static function destroy(User $user, int $program)
    {
        try {
            $query = CandidateProgram::query()->where('user_id', $user->id)
                ->where('program_id', $program)
                ->first();



            if (!$query) {
                return false;
            }




            $deleted = $query->delete();

            return $deleted;
        } catch (\Throwable $th) {
            Log::error("errors", [
                "error" => $th->getMessage(),
                "line"  => $th->getLine()
            ]);

            return 0;
        }
    }
}
