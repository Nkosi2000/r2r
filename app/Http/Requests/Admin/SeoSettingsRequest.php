<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SeoSettingsRequest extends FormRequest
{
    /**
     * The route's "manage-settings" gate already limits this to admins.
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
            'title' => ['required', 'string', 'max:120'],
            'share_title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:300'],
            'slogan' => ['required', 'string', 'max:160'],
            'keywords' => ['required', 'string', 'max:500'],
        ];
    }
}
