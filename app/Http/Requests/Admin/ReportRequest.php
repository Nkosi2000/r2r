<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    /**
     * Any signed-in staff member may edit content; the route's auth middleware guarantees one is present.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * A PDF is required when adding a report; when editing, leaving it empty keeps the current one.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'year' => ['required', 'integer', 'between:2000,'.(now()->year + 1)],
            'file' => [$this->isMethod('post') ? 'required' : 'nullable', 'file', 'mimes:pdf', 'max:20480'],
        ];
    }
}
