<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateProgram extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'program_id'
    ];


    // candidato pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // candidato pertence a um programa
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
