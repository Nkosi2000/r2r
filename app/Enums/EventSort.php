<?php

namespace App\Enums;

enum EventSort: string
{
    case Newest = 'newest';
    case Oldest = 'oldest';

    public function label(): string
    {
        return match ($this) {
            self::Newest => 'Newest first',
            self::Oldest => 'Oldest first',
        };
    }
}
