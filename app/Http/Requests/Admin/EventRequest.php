<?php

namespace App\Http\Requests\Admin;

use App\Models\Event;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRequest extends FormRequest
{
    /**
     * Any signed-in staff member may edit content; the route's auth middleware guarantees one is present.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Coordinates are optional but come as a pair, and must fall within South Africa so the pin lands on the map.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'place' => ['required', Rule::in(array_keys(Event::PROVINCES))],
            'held_on' => ['required', 'date'],
            'latitude' => ['nullable', 'required_with:longitude', 'numeric', 'between:-35,-22'],
            'longitude' => ['nullable', 'required_with:latitude', 'numeric', 'between:16,33'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'latitude.between' => 'The latitude must be inside South Africa (between -35 and -22).',
            'longitude.between' => 'The longitude must be inside South Africa (between 16 and 33).',
        ];
    }

    /**
     * Validated attributes, pinned to the centre of the province when no exact location was given.
     *
     * @return array<string, mixed>
     */
    public function eventAttributes(): array
    {
        $attributes = $this->validated();

        if (($attributes['latitude'] ?? null) === null) {
            [$attributes['latitude'], $attributes['longitude']] = Event::PROVINCES[$attributes['place']];
        }

        return $attributes;
    }
}
