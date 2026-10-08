<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
{
    /**
     * Any signed-in staff member may edit content; the route's auth middleware guarantees one is present.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * A logo is required when adding a partner; when editing, leaving it empty keeps the current one.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'url:http,https', 'max:255'],
            'logo' => [$this->isMethod('post') ? 'required' : 'nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ];
    }
}
