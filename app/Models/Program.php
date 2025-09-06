<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'start',
        'end',
        'status'
    ];

    public function users()
    {
        // muitos-para-muitos via candidate_programs
        return $this->belongsToMany(User::class, 'candidate_programs')
            ->withTimestamps()
            ->withPivot('deleted_at');
    }
}
