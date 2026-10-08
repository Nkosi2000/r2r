<?php

namespace App\Http\Requests\Admin;

use App\Models\Pillar;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PillarRequest extends FormRequest
{
    /**
     * Any signed-in staff member may edit content; the route's auth middleware guarantees one is present.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'step' => ['required', 'string', 'max:30'],
            'verb' => ['required', 'string', 'max:40'],
            'figure' => ['required', Rule::in(array_keys(Pillar::FIGURES))],
            'title' => ['required', 'string', 'max:120'],
            'body' => ['required', 'string', 'max:1000'],
        ];
    }
}
