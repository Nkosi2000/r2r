<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteContent;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A roadshow or expo. "place" is the province; events dated today or later count as upcoming.
 * Latitude/longitude place the event on the "On the road" map.
 */
#[Fillable(['title', 'place', 'held_on', 'latitude', 'longitude'])]
class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use FlushesSiteContent, HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'held_on' => 'date',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    /**
     * Display date, e.g. "17 Aug 2018".
     */
    protected function date(): Attribute
    {
        return Attribute::get(fn (): string => $this->held_on->format('d M Y'));
    }
}
