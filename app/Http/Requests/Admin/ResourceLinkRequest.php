<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ResourceLinkRequest extends FormRequest
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
            'group' => ['required', 'string', 'max:80'],
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:1000'],
            'url' => ['required', 'url:http,https', 'max:255'],
        ];
    }
}
