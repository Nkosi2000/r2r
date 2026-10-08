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
     * South Africa's provinces with a central point, used to pin an event on the map when no exact location is given.
     *
     * @var array<string, array{0: float, 1: float}> province => [latitude, longitude]
     */
    public const PROVINCES = [
        'Eastern Cape' => [-32.30, 26.42],
        'Free State' => [-28.45, 26.80],
        'Gauteng' => [-26.27, 28.11],
        'KwaZulu-Natal' => [-28.53, 30.90],
        'Limpopo' => [-23.40, 29.42],
        'Mpumalanga' => [-25.57, 30.53],
        'North West' => [-26.66, 25.28],
        'Northern Cape' => [-29.05, 21.86],
        'Western Cape' => [-33.23, 21.86],
    ];

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
