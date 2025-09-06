<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CandidateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'program' => [
                'required',
                Rule::unique('candidate_programs', 'program_id')
                    ->where(fn($query) => $query->where('user_id', auth()->id())),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'program.required' => "Informe o Identificador do programa que pretende se candidatar.",
            'program.unique'   => "Sr(a) {$this->user()->name}, já está inscrito neste programa.",
        ];
    }
}
