<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateProgramResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'program' => [
                'id' => $this->program->id,
                'name' => $this->program->name,
                'status' => $this->program->status,
                'start' => $this->program->start,
                'end' => $this->program->end,
            ],
            'created_at' => $this->created_at,
        ];
    }
}
