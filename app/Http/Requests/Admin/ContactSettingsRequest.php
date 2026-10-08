<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ContactSettingsRequest extends FormRequest
{
    /**
     * The route's "manage-settings" gate already limits this to admins.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * The address is typed one line per line, as it appears on the Contact page.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'address' => Str::of((string) $this->input('address'))->explode("\n")->map(fn (string $line): string => trim($line))->filter()->values()->all(),
        ]);
    }

    /**
     * The map pin places head office on the "On the road" map, so it must fall within South Africa.
     * The Google map on the Contact page is optional; its fields are all filled or all left empty.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'mobile' => ['required', 'string', 'max:30'],
            'address' => ['required', 'array', 'min:1', 'max:6'],
            'address.*' => ['string', 'max:100'],
            'postal.street_address' => ['required', 'string', 'max:150'],
            'postal.locality' => ['required', 'string', 'max:80'],
            'postal.region' => ['required', 'string', 'max:80'],
            'postal.postal_code' => ['required', 'string', 'max:10'],
            'postal.country_name' => ['required', 'string', 'max:80'],
            'postal.country_code' => ['required', 'string', 'size:2'],
            'map.label' => ['required', 'string', 'max:40'],
            'map.latitude' => ['required', 'numeric', 'between:-35,-22'],
            'map.longitude' => ['required', 'numeric', 'between:16,33'],
            'google_maps.place' => ['nullable', 'required_with:google_maps.url,google_maps.latitude,google_maps.longitude', 'string', 'max:100'],
            'google_maps.url' => ['nullable', 'required_with:google_maps.place', 'url:https', 'max:255'],
            'google_maps.latitude' => ['nullable', 'required_with:google_maps.place', 'numeric', 'between:-90,90'],
            'google_maps.longitude' => ['nullable', 'required_with:google_maps.place', 'numeric', 'between:-180,180'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'postal.street_address' => 'street address',
            'postal.locality' => 'town or city',
            'postal.region' => 'province',
            'postal.postal_code' => 'postal code',
            'postal.country_name' => 'country',
            'postal.country_code' => 'country code',
            'map.label' => 'map label',
            'map.latitude' => 'map latitude',
            'map.longitude' => 'map longitude',
            'google_maps.place' => 'Google Maps place name',
            'google_maps.url' => 'Google Maps link',
            'google_maps.latitude' => 'Google Maps latitude',
            'google_maps.longitude' => 'Google Maps longitude',
        ];
    }

    /**
     * The "contact" setting in the shape the site reads it (see SiteContent::contact()).
     *
     * @return array<string, mixed>
     */
    public function contactSetting(): array
    {
        $contact = $this->safe()->except('google_maps');
        $contact['map']['latitude'] = (float) $contact['map']['latitude'];
        $contact['map']['longitude'] = (float) $contact['map']['longitude'];

        if (filled($this->validated('google_maps.place'))) {
            $contact['google_maps'] = [
                'place' => $this->validated('google_maps.place'),
                'url' => $this->validated('google_maps.url'),
                'latitude' => (float) $this->validated('google_maps.latitude'),
                'longitude' => (float) $this->validated('google_maps.longitude'),
            ];
        }

        return $contact;
    }
}
