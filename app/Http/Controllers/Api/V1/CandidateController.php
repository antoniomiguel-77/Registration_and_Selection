<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CandidateRequest;
use App\Http\Resources\CandidateProgramResource;
use App\Repositories\CandidateProgramRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $userId = auth()->id();
            $programId = $request->program;

            $applications = CandidateProgramRepository::getApplication($userId, $programId);



            if (!$applications) {
                return response()->json([
                    "message" => "Nenhuma candidatura encontrada",
                    "programs" => []
                ], 404);
            }

            $applications =  CandidateProgramResource::collection($applications);


            return response()->json([
                "programs" => $applications
            ], 200);
        } catch (\Throwable $th) {
            Log::error("errors", [
                "error" => $th->getMessage(),
                "line" => $th->getLine()
            ]);
            return response()->json([
                "error" => "Falha ao criar conta.",
                "data" => $th->getMessage(),
            ], 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(CandidateRequest $request)
    {
     
        try {
            $user = $request->user();
            $program = CandidateProgramRepository::store($request->program,$user);
            Log::info('info',[
                'info'=>$program
            ]);
            if (!$program['status']) {
                return response()->json([
                    "message" => $program['message']
                ], 400);
            }

            return response()->json([
                "message" => $program['message']
            ], 200);
        } catch (\Throwable $th) {
            Log::error("errors", [
                "error" => $th->getMessage(),
                "line" => $th->getLine()
            ]);
            return response()->json([
                "error" => "Falha ao criar conta.",
                "data" => $th->getMessage(),
            ], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $user = $request->user();
            $application = CandidateProgramRepository::destroy($user, $request->program);

            if (!$application) {
                return response()->json([
                    "message" => "Candidatura não encontrada."
                ], 400);
            }

            return response()->json([
                "message" => "Sr(a), ".$user->name." Sua Candidatura foi cancelada com sucesso."
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "Falha ao realizar operação.",
                "data" => $th->getMessage(),
            ], 500);
        }
    }
}
