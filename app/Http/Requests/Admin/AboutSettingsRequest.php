<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class AboutSettingsRequest extends FormRequest
{
    /**
     * The route's "manage-settings" gate already limits this to admins.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * The mission is typed one commitment per line.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'mission' => Str::of((string) $this->input('mission'))->explode("\n")->map(fn (string $line): string => trim($line))->filter()->values()->all(),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'about' => ['required', 'string', 'max:2000'],
            'mission' => ['required', 'array', 'min:1', 'max:8'],
            'mission.*' => ['string', 'max:300'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'mission.required' => 'Add at least one mission commitment.',
            'mission.max' => 'Keep the mission to 8 commitments or fewer.',
            'mission.*.max' => 'Each commitment must be 300 characters or fewer.',
        ];
    }
}
