<?php

namespace App\Enums;

enum EventStatus: string
{
    case Upcoming = 'upcoming';
    case Past = 'past';

    public function label(): string
    {
        return match ($this) {
            self::Upcoming => 'Upcoming',
            self::Past => 'Past',
        };
    }
}
