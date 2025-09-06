<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CandidateProgramResource;
use App\Repositories\CandidateProgramRepository;
use Illuminate\Http\Request;

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



            if ($applications) {
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
            return response()->json([
                "error" => "Falha ao criar conta.",
                "data" => $th->getMessage(),
            ], 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $program = CandidateProgramRepository::store($request->id);

            if (!$program['status']) {
                return response()->json([
                    "message" => $program['message']
                ], 400);
            }

            return response()->json([
                "message" => $program['message']
            ], 200);
        } catch (\Throwable $th) {
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

            $application = CandidateProgramRepository::destroy(auth()->id(), $request->id);

            if (!$application) {
                return response()->json([
                    "message" => "Candidatura não encontrada."
                ], 400);
            }

            return response()->json([
                "message" => "Sua Candidatura foi cancelada com sucesso"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "Falha ao criar conta.",
                "data" => $th->getMessage(),
            ], 500);
        }
    }
}
