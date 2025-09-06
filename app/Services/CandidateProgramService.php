<?php

namespace App\Services;

use App\Models\Program;
use Carbon\Carbon;

class CandidateProgramService
{


    /**
     * Verifica se o programa aceita candidaturas.
     */
    public static function canApply(Program $program): bool
    {
        $today = Carbon::today();

        return $program->status === 'active' && $program->start <= $today && $today <= $program->end;
    }
}
