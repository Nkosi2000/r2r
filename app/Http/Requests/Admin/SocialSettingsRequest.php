<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SocialSettingsRequest extends FormRequest
{
    /**
     * The route's "manage-settings" gate already limits this to admins.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Rows left completely empty are dropped, so staff can remove a link by clearing it.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'social' => collect($this->input('social', []))
                ->filter(fn (mixed $row): bool => is_array($row) && (filled($row['platform'] ?? null) || filled($row['url'] ?? null)))
                ->values()
                ->all(),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'social' => ['array', 'max:10'],
            'social.*.platform' => ['required', 'string', 'max:40'],
            'social.*.url' => ['required', 'url:https', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'social.*.platform' => 'platform name',
            'social.*.url' => 'profile link',
        ];
    }
}
